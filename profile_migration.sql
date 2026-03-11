-- Profile Migration SQL
-- Add profile columns to users table

ALTER TABLE `users` 
ADD COLUMN `student_id` VARCHAR(20) NULL AFTER `role`,
ADD COLUMN `course` VARCHAR(100) NULL AFTER `student_id`,
ADD COLUMN `year_level` TINYINT NULL AFTER `course`,
ADD COLUMN `section` VARCHAR(50) NULL AFTER `year_level`,
ADD COLUMN `phone` VARCHAR(20) NULL AFTER `section`,
ADD COLUMN `address` TEXT NULL AFTER `phone`,
ADD COLUMN `profile_image` VARCHAR(255) NULL AFTER `address`;

-- Update existing admin user with sample data
UPDATE `users` 
SET 
    `student_id` = '2024-00001',
    `course` = 'BSIT',
    `year_level` = 4,
    `section` = 'IT4A',
    `phone` = '0912-345-6789',
    `address` = 'Sample Address, City, Province'
WHERE `id` = 1;

SELECT '✓ Profile columns added successfully!' AS status;
