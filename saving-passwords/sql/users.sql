CREATE DATABASE user_crud_db;

USE user_crud_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Needs to be 255 for PHP's password_hash()
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);