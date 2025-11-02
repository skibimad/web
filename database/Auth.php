<?php
// Authentication Helper

class Auth {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
            session_name(SESSION_NAME);
            session_start();
        }
    }
    
    public static function login($userId, $username) {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
    }
    
    public static function logout() {
        self::startSession();
        $_SESSION = [];
        session_destroy();
    }
    
    public static function isLoggedIn() {
        self::startSession();
        
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            return false;
        }
        
        // Check session timeout
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
            self::logout();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
        return true;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /admin/login.php');
            exit();
        }
    }
    
    public static function getUserId() {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }
    
    public static function getUsername() {
        self::startSession();
        return $_SESSION['username'] ?? null;
    }
}
