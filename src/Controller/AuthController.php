<?php

namespace App\Controller;

use App\Core\Config;
use App\Core\Controller;
use App\Exception\InvalidLoginException;
use App\Exception\SignUpException;
use App\Helper\Recaptcha;
use App\Model\Account;
use App\Model\Account\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{

    

    /**
     * Login user
     *
     * @return void
     */
    public function login(): void
    {
        //----- test
        $this->getRequest()->setSession('uid', 5);
        $this->redirect('/service/index');
        //------

        if (!$this->getRequest()->isPost()) {
            $this->getRequest()->clearSession();
            $this->render('auth/login');
            return;
        }

        try {      
            $this->assertRecaptcha();

            $loginData = $this->getRequest()->getPost();

            $this->validateLoginData($loginData);

            $account = (new Account())->findByEmail($loginData['email'] ?? '');

            if (!$account || !$account->getId() || !password_verify($loginData['password'] ?? '', $account->getPassword())) {
                throw new InvalidLoginException('Invalid Credentials');
            }

            $this->getRequest()->setSession('uid', $account->getId());

            if (User::isAdmin()) {
                $this->redirect('/service/index');
                return;
            }

            if (!User::getInstance()->hasParcels()) {
                $this->redirect('/parcel/add');
                return;
            } else {
                $this->redirect('/parcel/index');
                return;
            }

        } catch (\Throwable $e) {
            $this->getRequest()->addError($e->getMessage());
        }

        $this->redirectReferer();
    }

    

    /**
     * Validate login data
     *
     * @param array $data  The login data
     */
    private function validateLoginData(array $data): void
    {
        if (empty($data['email']) || empty($data['password'])) {
            throw new \InvalidArgumentException('Please enter your email and password');
        }
        
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/auth/login');
    }

    /**
     * Render forgot password page
     *
     * @return void
     */
    public function forgot(): void
    {
        if (!$this->getRequest()->isPost()) {
            $this->render('auth/forgot');
            return;
        }
        try {

            $this->assertRecaptcha();

            $data = $this->getRequest()->post();
            $userEmail = $data['email'];

            if (!$this->validateForgotPasswordData($data)) {
                throw new \InvalidArgumentException('Invalid data provided');
            }

            $account = (new Account())->loadByEmail($userEmail);
            if (!$account->getId()) {
                throw new \InvalidArgumentException('No account found with that email address');
            }
            $resetToken = $account->createResetToken();
            $resetLink = rtrim(Config::get('domain'), '/') . '/auth/reset?token=' . $resetToken;

            ob_start();
            require __DIR__ . '/../../views/email/reset_password.phtml';
            $emailContent = ob_get_clean();

            // Send reset email

            // Use PHPMailer to send the reset email

            
            try {
                $mail = new PHPMailer(true);
                $config = Config::get('email');
                $mail->isSMTP();
                $mail->setFrom($config['from_email'], $config['from_name']);
                $mail->addReplyTo($config['reply_to'], $config['from_name']);
                $mail->addAddress($userEmail);
                $mail->isHTML(true);
                $mail->SMTPAuth     = true;
                $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
                //$mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Host         = $config['smtp_host'];
                $mail->Port         = $config['smtp_port'];
                $mail->Username     = $config['smtp_username'];
                $mail->Password     = $config['smtp_password'];
                $mail->Subject      = 'Password Reset Request';
                $mail->Body         = $emailContent;

                $mail->send();
            } catch (Exception $e) {
                throw new \RuntimeException('Could not send reset email. Mailer Error: ' . $mail->ErrorInfo);
            }

            $this->getRequest()->addInfo('A password reset link has been sent to your email address.');
            $this->redirect('/auth/login');
            return;

        } catch (\Throwable $e) {
            $this->getRequest()->addError('An error occurred: ' . $e->getMessage());
            
        }

        $this->redirectReferer();
    }

    /**
     * Send a welcome email to the user after successful signup
     *
     * @param Account $account The account object of the newly created user
     * @return void
     */
    private function sendWelcomeEmail(Account $account): void
    {
        try {
            ob_start();
            require __DIR__ . '/../../views/email/welcome.phtml';
            $emailContent = ob_get_clean();

            $mail = new PHPMailer(true);
            $config = Config::get('email');
            $mail->isSMTP();
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($account->get('email'));
            $mail->addReplyTo($config['reply_to'], $config['from_name']);
            $mail->isHTML(true);
            $mail->SMTPAuth     = true;
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
            //$mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Host         = $config['smtp_host'];
            $mail->Port         = $config['smtp_port'];
            $mail->Username     = $config['smtp_username'];
            $mail->Password     = $config['smtp_password'];
            $mail->Subject      = 'Welcome to Aghawk Portal - Your account is Ready!';
            $mail->Body         = $emailContent;

            $mail->send();
        } catch (Exception $e) {
            // Log the error or handle it as needed
        }
    }

    /**
     * Reset password using a token
     * This method handles both displaying the reset form and processing the reset request
     *
     * @return void
     */
    public function reset(): void
    {
        $token = $this->getRequest()->request('token');
        if (!$token) {
            $this->getRequest()->addError('Invalid reset token');
            $this->redirect('/auth/forgot');
            return;
        }

        if (!$this->getRequest()->isPost()) {
            $account = (new Account())->findByResetToken($token);
            if (!$account->getId()) {
                $this->getRequest()->addError('Invalid or expired reset token');
                $this->redirect('/auth/forgot');
                return;
            }
            $this->render('auth/reset', ['token' => $token, 'account' => $account]);
            return;
        }

        try {

            $this->assertRecaptcha();

            $account = (new Account())->findByResetToken($token);
            if (!$account) {
                throw new \InvalidArgumentException('Invalid or expired reset token');
            }

            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $newPassword = $data['pvl'] ?? '';
                $newPasswordRepeat = $data['pvlr'] ?? '';
                if (empty($newPassword) || empty($newPasswordRepeat)) {
                    throw new \InvalidArgumentException('Please fill in all fields');
                }
                if ($newPassword !== $newPasswordRepeat) {
                    throw new \InvalidArgumentException('Passwords do not match');
                }

                $account->resetPassword($token, $newPassword, $newPasswordRepeat);

                $this->getRequest()->addInfo('Your password has been reset successfully.');
                $this->redirect('/auth/login');
            }

        } catch (\Throwable $e) {
            $this->getRequest()->addError('An error occurred: ' . $e->getMessage());
            $this->redirectReferer();
        }
    }

    /**
     * Validate forgot password data
     *
     * @param array $data The forgot password data
     * @return bool True if valid, false otherwise
     */
    private function validateForgotPasswordData(array $data): bool
    {
        if (empty($data['email'])) {
            $this->getRequest()->addError('Please enter your email address');
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->getRequest()->addError('Invalid email address');
            return false;
        }

        $account = (new Account())->findByEmail($data['email']);
        if (!$account || !$account->getId()) {
            $this->getRequest()->addError('No account found with that email address');
            return false;
        }

        return true;
    }

}
