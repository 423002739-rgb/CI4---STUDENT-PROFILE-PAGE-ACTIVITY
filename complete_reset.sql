-- Complete Database Reset for CI4 Starter Panel

-- Drop all tables first
DROP TABLE IF EXISTS `user_access`;
DROP TABLE IF EXISTS `user_submenu`;
DROP TABLE IF EXISTS `user_menu`;
DROP TABLE IF EXISTS `user_menu_category`;
DROP TABLE IF EXISTS `user_role`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `records`;

-- 1. Create user_role table
CREATE TABLE `user_role` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_role` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- 2. Create users table
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(5) UNSIGNED NOT NULL DEFAULT 2,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert admin user (password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW());

-- 3. Create user_menu_category table
CREATE TABLE `user_menu_category` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_menu_category` (`id`, `menu_category`) VALUES
(1, 'Dashboard'),
(2, 'Management');

-- 4. Create user_menu table
CREATE TABLE `user_menu` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_category` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` text,
  `parent` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_menu` (`id`, `menu_category`, `title`, `url`, `icon`, `parent`) VALUES
(1, 1, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 0),
(2, 2, 'Students', 'students', 'fas fa-users', 0),
(3, 2, 'Users', 'users', 'fas fa-user-cog', 0),
(4, 2, 'Menu Management', 'menu-management', 'fas fa-bars', 0),
(5, 1, 'Profile', 'profile', 'fas fa-user', 0);

-- 5. Create user_submenu table
CREATE TABLE `user_submenu` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Create user_access table
CREATE TABLE `user_access` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) UNSIGNED NOT NULL,
  `menu_category_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `menu_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `submenu_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Grant admin access to all menus
INSERT INTO `user_access` (`role_id`, `menu_category_id`, `menu_id`, `submenu_id`) VALUES
(1, 1, 1, 0),
(1, 1, 5, 0),
(1, 2, 2, 0),
(1, 2, 3, 0),
(1, 2, 4, 0);

-- 7. Create students table
CREATE TABLE `students` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_level` tinyint(4) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample students
INSERT INTO `students` (`name`, `email`, `student_id`, `course`, `year_level`, `section`, `created_at`) VALUES
('Juan Dela Cruz', 'juan@example.com', '2024-001', 'BSIT', 1, 'A', NOW()),
('Maria Santos', 'maria@example.com', '2024-002', 'BSCS', 2, 'B', NOW());

-- 8. Create records table (if needed)
CREATE TABLE `records` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT '✓ Database reset complete!' AS status;
SELECT '✓ Admin Login: admin@example.com / admin123' AS credentials;
SELECT '✓ All tables created successfully!' AS info;
