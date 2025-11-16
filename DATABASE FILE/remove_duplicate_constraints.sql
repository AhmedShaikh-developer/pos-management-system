-- =============================================
-- Remove UNIQUE constraints that prevent duplicate phone/address entries
-- Run this in phpMyAdmin if you're getting errors when adding entries with same phone/address
-- =============================================

-- IMPORTANT: Run these commands one by one in phpMyAdmin
-- If you get "Unknown key" errors, that means the index doesn't exist - just skip that command

-- For MySQL 5.7+ or MariaDB 10.2.2+, use DROP INDEX IF EXISTS:
DROP INDEX IF EXISTS `phone` ON `customers`;
DROP INDEX IF EXISTS `phone_2` ON `customers`;
DROP INDEX IF EXISTS `phone_unique` ON `customers`;
DROP INDEX IF EXISTS `address` ON `customers`;
DROP INDEX IF EXISTS `address_2` ON `customers`;
DROP INDEX IF EXISTS `address_unique` ON `customers`;
DROP INDEX IF EXISTS `phone` ON `vendors`;
DROP INDEX IF EXISTS `phone_2` ON `vendors`;
DROP INDEX IF EXISTS `phone_unique` ON `vendors`;
DROP INDEX IF EXISTS `address` ON `vendors`;
DROP INDEX IF EXISTS `address_2` ON `vendors`;
DROP INDEX IF EXISTS `address_unique` ON `vendors`;

-- =============================================
-- Alternative method for older MySQL versions (if DROP INDEX IF EXISTS doesn't work):
-- =============================================
-- Run these one by one and ignore "Unknown key" errors:

-- ALTER TABLE `customers` DROP INDEX `phone`;
-- ALTER TABLE `customers` DROP INDEX `phone_2`;
-- ALTER TABLE `customers` DROP INDEX `phone_unique`;
-- ALTER TABLE `customers` DROP INDEX `address`;
-- ALTER TABLE `customers` DROP INDEX `address_2`;
-- ALTER TABLE `customers` DROP INDEX `address_unique`;
-- ALTER TABLE `vendors` DROP INDEX `phone`;
-- ALTER TABLE `vendors` DROP INDEX `phone_2`;
-- ALTER TABLE `vendors` DROP INDEX `phone_unique`;
-- ALTER TABLE `vendors` DROP INDEX `address`;
-- ALTER TABLE `vendors` DROP INDEX `address_2`;
-- ALTER TABLE `vendors` DROP INDEX `address_unique`;

-- =============================================
-- To check what indexes exist on your tables, run:
-- =============================================
-- SHOW INDEX FROM `customers`;
-- SHOW INDEX FROM `vendors`;

