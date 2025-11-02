<?php

namespace App\Core;

/**
 * Authentication System
 * Handles user login, session management, and authorization
 */
class Auth
{
    private Database $db;
    private const SESSION_KEY = 'admin_user_id';

    public function __construct()
    {
        $this->db = Database::getInstance();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Attempt to login with username and password
     */
    public function login(string $username, string $password): bool
    {
        $stmt = $this->db->query(
            "SELECT * FROM admin_users WHERE username = ? AND active = 1 LIMIT 1",
            [$username]
        );
        
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION[self::SESSION_KEY] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            
            // Update last login
            $this->db->query(
                "UPDATE admin_users SET last_login = CURRENT_TIMESTAMP WHERE id = ?",
                [$user['id']]
            );
            
            return true;
        }
        
        return false;
    }

    /**
     * Logout current user
     */
    public function logout(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
        unset($_SESSION['admin_username']);
        session_destroy();
    }

    /**
     * Check if user is logged in
     */
    public function check(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]);
    }

    /**
     * Get current user ID
     */
    public function userId(): ?int
    {
        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    /**
     * Get current username
     */
    public function username(): ?string
    {
        return $_SESSION['admin_username'] ?? null;
    }

    /**
     * Require authentication - redirect to login if not authenticated
     */
    public function require(): void
    {
        if (!$this->check()) {
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Create a new admin user
     */
    public function createUser(string $username, string $password, string $email): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $this->db->query(
                "INSERT INTO admin_users (username, email, password_hash) VALUES (?, ?, ?)",
                [$username, $email, $passwordHash]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
