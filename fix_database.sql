-- Fix database errors for CI4 Starter Panel

-- 1. Check if user_role table exists, if not create it
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Insert default roles if table is empty
INSERT IGNORE INTO `user_role` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- 3. Fix users table if it has wrong column names
-- Check if 'fullname' column exists and rename to 'name'
SET @dbname = DATABASE();
SET @tablename = 'users';
SET @columnname = 'fullname';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'ALTER TABLE users CHANGE fullname name VARCHAR(255);',
  'SELECT 1;'
));
PREPARE alterIfExists FROM @preparedStatement;
EXECUTE alterIfExists;
DEALLOCATE PREPARE alterIfExists;

-- Check if 'username' column exists and rename to 'email'
SET @columnname = 'username';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'ALTER TABLE users CHANGE username email VARCHAR(255);',
  'SELECT 1;'
));
PREPARE alterIfExists FROM @preparedStatement;
EXECUTE alterIfExists;
DEALLOCATE PREPARE alterIfExists;

-- 4. Ensure user_access table exists
CREATE TABLE IF NOT EXISTS `user_access` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) UNSIGNED NOT NULL,
  `menu_category_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL,
  `submenu_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Ensure user_menu table exists
CREATE TABLE IF NOT EXISTS `user_menu` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_category` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` text,
  `parent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Ensure user_menu_category table exists
CREATE TABLE IF NOT EXISTS `user_menu_category` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Insert default menu categories if empty
INSERT IGNORE INTO `user_menu_category` (`id`, `menu_category`) VALUES
(1, 'Dashboard'),
(2, 'Management');

-- 8. Insert default menus if empty
INSERT IGNORE INTO `user_menu` (`id`, `menu_category`, `title`, `url`, `icon`, `parent`) VALUES
(1, 1, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 0),
(2, 2, 'Students', 'students', 'fas fa-users', 0),
(3, 2, 'Users', 'users', 'fas fa-user-cog', 0);

-- 9. Grant admin access to all menus
INSERT IGNORE INTO `user_access` (`role_id`, `menu_category_id`, `menu_id`, `submenu_id`) VALUES
(1, 1, 1, 0),
(1, 2, 2, 0),
(1, 2, 3, 0);

-- Done!
SELECT 'Database fixed successfully!' AS status;
