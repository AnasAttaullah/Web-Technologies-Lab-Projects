-- Create database
CREATE DATABASE IF NOT EXISTS student_crud;

-- Use database
USE student_crud;

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    course VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO students (name, email, phone, address, course) VALUES
('John Doe', 'john.doe@example.com', '123-456-7890', '123 Main St, City', 'Computer Science'),
('Jane Smith', 'jane.smith@example.com', '098-765-4321', '456 Oak Ave, Town', 'Engineering'),
('Mike Johnson', 'mike.johnson@example.com', '555-123-4567', '789 Pine Rd, Village', 'Mathematics');
