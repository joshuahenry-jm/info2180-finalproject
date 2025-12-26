CREATE DATABASE dolphin_crm;
USE dolphin_crm;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);




CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(10),
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    company VARCHAR(100),
    type VARCHAR(20),
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);



CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (contact_id) REFERENCES contacts(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);


INSERT INTO users (firstname, lastname, email, password_hash, role)
VALUES (
    'Admin', 'User', 'admin@project2.com', '$2y$10$2DINgtrnrVkIP3k7ocM/Ie1nug7atswJ3fRobwaHyS2XOrpY2z6T6',  'Admin'
);
