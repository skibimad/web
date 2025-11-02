-- Migration: Add FSX admin user
-- Version: 002
-- Created: 2024-11-02

-- Insert FSX admin user (username: fsx, password: 111111)
-- Password hash for '111111'
INSERT IGNORE INTO admin_users (id, username, email, password_hash) VALUES
(2, 'fsx', 'fsx@skibidimadness.local', '$2y$10$jN5EZEmvC3JNGJrYQS3GC.yHqZhQF5fGQN3f8T8vRO5Gn0qGm7g6K');
