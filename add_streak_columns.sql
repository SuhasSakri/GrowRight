-- Run this SQL in phpMyAdmin to add streak columns to profiles table

ALTER TABLE profiles 
ADD COLUMN IF NOT EXISTS streak INT DEFAULT 1,
ADD COLUMN IF NOT EXISTS last_login DATE DEFAULT NULL;
