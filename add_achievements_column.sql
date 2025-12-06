-- Run these SQL commands ONE BY ONE in phpMyAdmin

ALTER TABLE profiles ADD COLUMN water_intake INT DEFAULT 0;

ALTER TABLE profiles ADD COLUMN water_intake_date DATE DEFAULT NULL;

ALTER TABLE profiles ADD COLUMN last_water_reminder BIGINT DEFAULT NULL;

ALTER TABLE profiles ADD COLUMN achievements TEXT;
