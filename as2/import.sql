CREATE DATABASE IF NOT EXISTS jobs DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE jobs;

DROP TABLE IF EXISTS applicants;
DROP TABLE IF EXISTS enquiries;
DROP TABLE IF EXISTS job;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  companyName VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(45) DEFAULT NULL,
  description TEXT,
  salary VARCHAR(45) DEFAULT NULL,
  closingDate DATE DEFAULT NULL,
  categoryId INT DEFAULT NULL,
  location VARCHAR(255) DEFAULT NULL,
  dateAdded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  archived TINYINT(1) NOT NULL DEFAULT 0,
  clientId INT DEFAULT NULL,
  FOREIGN KEY (categoryId) REFERENCES category(id) ON DELETE SET NULL,
  FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE applicants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(45) DEFAULT NULL,
  email VARCHAR(45) DEFAULT NULL,
  details TEXT,
  jobId INT DEFAULT NULL,
  cv VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (jobId) REFERENCES job(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE enquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telephone VARCHAR(50) NOT NULL,
  enquiry TEXT NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  staffId INT NULL,
  FOREIGN KEY (staffId) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (id, username, password, role) VALUES
(1, 'admin', '$2y$12$NWzo6Yv3TcDPfl3niq2URua5fqXkmkb3FQ37VNWKOo8pqDPvejZzu', 'manager');
-- default admin password: letmein

INSERT INTO clients (id, companyName, username, password) VALUES
(1, 'Northampton General Hospital', 'hospitalclient', '$2y$12$NWzo6Yv3TcDPfl3niq2URua5fqXkmkb3FQ37VNWKOo8pqDPvejZzu');
-- default client password: letmein

INSERT INTO category (id, name) VALUES (1,'IT'),(2,'Human Resources'),(4,'Sales');

INSERT INTO job (id,title,description,salary,closingDate,categoryId,location,dateAdded,archived,clientId) VALUES
(3,'First level tech support','Job overview:\n\nTo work alongside the IT field based team in one of our acute Hospital sites.','£15,000 - £18,000','2026-07-09',1,'Northampton','2026-06-01 09:00:00',0,1),
(4,'IT Infrastructure Manager','As an experienced IT Infrastructure Manager, you will work closely with the Head of IT.','£45,000 - £58,000','2026-08-15',1,'Northampton','2026-06-02 09:00:00',0,1),
(5,'Sales Assistant','Our client is an award winning sales and marketing organisation looking to enhance their sales team.','£12,000 - £15,000','2026-07-29',4,'Northampton','2026-06-03 09:00:00',0,NULL),
(6,'HR Manager','An ambitious HR Manager is required to help deliver an effective Human Resource service.','£35,000 - £40,000','2026-09-29',2,'Northampton','2026-06-04 09:00:00',0,NULL);

INSERT INTO applicants (name,email,details,jobId) VALUES
('Test Applicant','applicant@example.com','Experienced support technician.',3);
