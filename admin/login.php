<?php
require_once '../config/config.php';
require_once '../core/Database.php';
require_once '../core/Security.php';
require_once '../core/Model.php';
require_once '../models/User.php';

// If already logged in, redirect to dashboard
if (Security::isAuthenticated()) {
    header('Location: index.php');
    exit;
}

$error = '';

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if ($user && Security::verifyPassword($password, $user['password'])) {
            Security::login($user['id'], $user['username']);
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Please enter username and password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Skibidi Madness</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght=400;700;900&family=Rajdhani:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/admin.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a0f 0%, #1e1e28 100%);
        }
        .login-box {
            background: rgba(20, 20, 25, 0.95);
            border: 2px solid var(--color-primary);
            border-radius: 15px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 30px rgba(255, 51, 102, 0.3);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: var(--color-primary);
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            margin: 0 0 10px 0;
        }
        .login-header p {
            color: var(--color-secondary);
            font-size: 0.9rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: var(--color-text);
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            background: rgba(10, 10, 15, 0.8);
            border: 1px solid var(--color-border);
            border-radius: 5px;
            color: var(--color-text);
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--color-primary);
        }
        .error-message {
            background: rgba(255, 51, 102, 0.1);
            border: 1px solid var(--color-primary);
            color: var(--color-primary);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 51, 102, 0.4);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: var(--color-secondary);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link a:hover {
            color: var(--color-accent);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>SKIBIDI MADNESS</h1>
                <p>Admin Panel Login</p>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
            
            <div class="back-link">
                <a href="../index.php">← Back to Site</a>
            </div>
        </div>
    </div>
</body>
</html>
