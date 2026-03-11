-- Fix users table structure

-- Check current structure
DESCRIBE users;

-- Add role column if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `role` INT(5) UNSIGNED NOT NULL DEFAULT 2 AFTER `password`;

-- Add name column if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `name` VARCHAR(255) NOT NULL AFTER `id`;

-- Add email column if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `email` VARCHAR(255) NOT NULL AFTER `name`;

-- Add created_at if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `created_at` DATETIME NULL AFTER `role`;

-- Add updated_at if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `updated_at` DATETIME NULL AFTER `created_at`;

-- If old columns exist, copy data and drop them
-- Copy fullname to name if fullname exists
UPDATE users SET name = fullname WHERE fullname IS NOT NULL AND fullname != '';

-- Copy username to email if username exists
UPDATE users SET email = username WHERE username IS NOT NULL AND username != '';

-- Drop old columns if they exist
ALTER TABLE users DROP COLUMN IF EXISTS `fullname`;
ALTER TABLE users DROP COLUMN IF EXISTS `username`;

-- Show final structure
DESCRIBE users;

SELECT 'Users table fixed successfully!' AS status;
