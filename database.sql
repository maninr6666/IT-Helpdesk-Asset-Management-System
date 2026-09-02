CREATE DATABASE IF NOT EXISTS it_helpdesk;
USE it_helpdesk;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    department VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asset_tag VARCHAR(50) NOT NULL UNIQUE,
    asset_type VARCHAR(50) NOT NULL,
    brand VARCHAR(80),
    model VARCHAR(100),
    serial_number VARCHAR(100) UNIQUE,
    assigned_to INT NULL,
    status ENUM('Available','Assigned','Repair','Retired') DEFAULT 'Available',
    purchase_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_no VARCHAR(30) NOT NULL UNIQUE,
    user_id INT NULL,
    subject VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(80) NOT NULL,
    priority ENUM('Low','Medium','High','Critical') DEFAULT 'Medium',
    status ENUM('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
    assigned_to VARCHAR(100) NULL,
    resolution TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO users (name,email,department) VALUES
('Rahul Kumar','rahul@example.com','Finance'),
('Priya Sharma','priya@example.com','HR'),
('Arun Patel','arun@example.com','Engineering');

INSERT IGNORE INTO assets
(asset_tag,asset_type,brand,model,serial_number,assigned_to,status,purchase_date) VALUES
('LAP-1001','Laptop','Dell','Latitude 5440','SN-DELL-1001',1,'Assigned','2025-01-10'),
('MON-1001','Monitor','LG','24MP60G','SN-LG-1001',2,'Assigned','2025-02-12'),
('LAP-1002','Laptop','Lenovo','ThinkPad E14','SN-LEN-1002',NULL,'Available','2025-03-05');
