<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Database.php';
require_once __DIR__ . '/../../database/Auth.php';

// Require login for all admin pages
Auth::requireLogin();

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?> - Skibidi Madness</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Rajdhani', sans-serif;
            background: linear-gradient(135deg, #0a0a0f 0%, #1e1e28 100%);
            color: #fff;
            min-height: 100vh;
        }
        
        .admin-navbar {
            background: rgba(20, 20, 25, 0.95);
            border-bottom: 2px solid #ff3366;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-logo {
            font-family: 'Orbitron', sans-serif;
        }
        
        .logo-main {
            color: #ff3366;
            font-size: 1.5em;
            font-weight: 900;
        }
        
        .logo-sub {
            color: #00ffcc;
            font-size: 0.9em;
            margin-left: 10px;
        }
        
        .admin-menu {
            display: flex;
            list-style: none;
            gap: 20px;
            align-items: center;
        }
        
        .admin-menu a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .admin-menu a:hover,
        .admin-menu a.active {
            background: #ff3366;
            color: #fff;
        }
        
        .admin-main {
            padding: 30px 0;
        }
        
        .admin-title {
            font-family: 'Orbitron', sans-serif;
            color: #ff3366;
            font-size: 2.5em;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff3366 0%, #ff6b9d 100%);
            color: #fff;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 51, 102, 0.4);
        }
        
        .btn-secondary {
            background: #00ffcc;
            color: #0a0a0f;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 204, 0.4);
        }
        
        .btn-danger {
            background: #dc3545;
            color: #fff;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .content-card {
            background: rgba(20, 20, 25, 0.8);
            border: 1px solid rgba(255, 51, 102, 0.3);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #00ffcc;
        }
        
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group input[type="url"],
        .form-group input[type="file"],
        .form-group input[type="password"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 51, 102, 0.3);
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            font-family: 'Rajdhani', sans-serif;
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff3366;
            background: rgba(255, 255, 255, 0.15);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 51, 102, 0.2);
        }
        
        table th {
            background: rgba(255, 51, 102, 0.2);
            color: #00ffcc;
            font-weight: 700;
        }
        
        table tr:hover {
            background: rgba(255, 51, 102, 0.1);
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .success-message {
            background: rgba(0, 255, 204, 0.2);
            color: #00ffcc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #00ffcc;
        }
        
        .error-message {
            background: rgba(255, 51, 102, 0.2);
            color: #ff3366;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #ff3366;
        }
        
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <div class="admin-container">
            <div class="navbar-content">
                <div class="admin-logo">
                    <span class="logo-main">SKIBIDI</span>
                    <span class="logo-sub">ADMIN PANEL</span>
                </div>
                <ul class="admin-menu">
                    <li><a href="/admin/index.php" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="/admin/episodes.php" class="<?php echo $currentPage === 'episodes' ? 'active' : ''; ?>">Episodes</a></li>
                    <li><a href="/admin/heroes.php" class="<?php echo $currentPage === 'heroes' ? 'active' : ''; ?>">Heroes</a></li>
                    <li><a href="/admin/blog.php" class="<?php echo $currentPage === 'blog' ? 'active' : ''; ?>">Blog</a></li>
                    <li><a href="/admin/landing.php" class="<?php echo $currentPage === 'landing' ? 'active' : ''; ?>">Landing Page</a></li>
                    <li><a href="/admin/settings.php" class="<?php echo $currentPage === 'settings' ? 'active' : ''; ?>">Settings</a></li>
                    <li><a href="/" target="_blank">View Site</a></li>
                    <li><a href="/admin/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="admin-main">
        <div class="admin-container">
