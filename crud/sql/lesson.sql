-- SQL to create the database (if it doesn't already exist)
CREATE DATABASE IF NOT EXISTS `full_crud`; 

-- Set the default database for the next commands
USE `full_crud`;

-- SQL to create the table
CREATE TABLE IF NOT EXISTS `form_data` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `radio_option` VARCHAR(50) NOT NULL,
    `checkbox_option` VARCHAR(3) NOT NULL DEFAULT 'No',
    `message` TEXT NOT NULL,
    `text_input` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;