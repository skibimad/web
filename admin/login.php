<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../database/Auth.php';
require_once __DIR__ . '/../database/models/User.php';

Auth::startSession();

// If already logged in, redirect to dashboard
if (Auth::isLoggedIn()) {
    header('Location: /admin/index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            Auth::login($user['id'], $user['username']);
            header('Location: /admin/index.php');
            exit();
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Please enter both username and password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Skibidi Madness</title>
    <link rel="stylesheet" href="/styles/main.css">
    <style>
        body {
            background: linear-gradient(135deg, #0a0a0f 0%, #1e1e28 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
        }
        .login-container {
            background: rgba(20, 20, 25, 0.9);
            border: 2px solid #ff3366;
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 30px rgba(255, 51, 102, 0.3);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo h1 {
            font-family: 'Orbitron', sans-serif;
            color: #ff3366;
            font-size: 2em;
            margin: 0 0 10px 0;
        }
        .login-logo p {
            color: #00ffcc;
            font-size: 1.1em;
            margin: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #fff;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 51, 102, 0.3);
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff3366;
            background: rgba(255, 255, 255, 0.15);
        }
        .error-message {
            background: rgba(255, 51, 102, 0.2);
            color: #ff3366;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff3366 0%, #ff6b9d 100%);
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Orbitron', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 51, 102, 0.4);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #00ffcc;
            text-decoration: none;
            transition: color 0.3s;
        }
        .back-link a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>SKIBIDI MADNESS</h1>
            <p>Admin Panel</p>
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
            
            <button type="submit" class="btn-login">LOGIN</button>
        </form>
        
        <div class="back-link">
            <a href="/">← Back to Website</a>
        </div>
    </div>
</body>
</html>
