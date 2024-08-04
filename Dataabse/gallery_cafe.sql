--create Database--
CREATE DATABASE thegallerycafe;
USE thegallerycafe;

--Roles--
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

--users--
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Insert roles--
INSERT INTO roles (role_name) VALUES ('user'), ('staff'), ('admin');
--Primary Admin--
INSERT INTO users (name, email, password, role_id) VALUES ('Sahee', 'Sahee@gmail.com', PASSWORD('1234'), 3);

--create add manu items table--
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    item_description TEXT NOT NULL,
    item_price DECIMAL(10, 2) NOT NULL,
    item_cultures VARCHAR(50) NOT NULL,
    item_type VARCHAR(50) NOT NULL,
    item_image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--create Food culture--
CREATE TABLE food_culture (
    id INT AUTO_INCREMENT PRIMARY KEY,
    culture_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
