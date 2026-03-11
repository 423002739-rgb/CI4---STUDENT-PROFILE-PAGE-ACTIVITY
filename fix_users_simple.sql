-- Fix users table structure (Compatible with all MySQL versions)

-- First, let's see what we have
SELECT 'Current users table structure:' AS info;
SHOW COLUMNS FROM users;

-- Drop the table and recreate it properly
DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(5) UNSIGNED NOT NULL DEFAULT 2,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default admin user (password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW());

SELECT 'Users table recreated successfully!' AS status;
SELECT 'Default admin login:' AS info, 'Email: admin@example.com' AS email, 'Password: admin123' AS password;
