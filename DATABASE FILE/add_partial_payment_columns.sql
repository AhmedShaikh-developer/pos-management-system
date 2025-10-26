-- =============================================
-- MIGRATION: Add Partial Payment Support
-- Run this in phpMyAdmin NOW to fix the error
-- =============================================

-- Step 1: Add missing columns to your existing partial_payments table
ALTER TABLE `partial_payments` 
ADD COLUMN `balance_remaining` float NOT NULL DEFAULT 0 AFTER `amount_paid`,
ADD COLUMN `notes` text COLLATE utf8_spanish_ci AFTER `reference_no`;

-- Step 2: Create new table for purchase partial payments
CREATE TABLE IF NOT EXISTS `purchase_partial_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_slip_id` int(11) NOT NULL,
  `amount_paid` float NOT NULL,
  `balance_remaining` float NOT NULL,
  `payment_method` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `reference_no` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `notes` text COLLATE utf8_spanish_ci,
  `paid_by` int(11) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `purchase_slip_id` (`purchase_slip_id`),
  KEY `paid_by` (`paid_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Step 3: Add 'Partial' to sales payment_status enum (if not already added)
ALTER TABLE `sales` 
MODIFY `payment_status` enum('Paid','Unpaid','Partial') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Paid';

-- Step 4: Add 'Partial' to purchase_slips payment_status enum (if not already added)
ALTER TABLE `purchase_slips` 
MODIFY `payment_status` enum('Paid','Unpaid','Partial') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Unpaid';

-- =============================================
-- Migration Complete!
-- =============================================

