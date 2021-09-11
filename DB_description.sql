USE mulwacok_attachmentdb;

CREATE TABLE student (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    course VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attachment (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name_of_company VARCHAR(50) NOT NULL,
    location VARCHAR(50) NOT NULL,
    description TEXT NOT NULL
);

ALTER TABLE attachment
ADD studentid INT AFTER description;

ALTER TABLE attachment
ADD FOREIGN KEY (studentid) REFERENCES student(id);

CREATE TABLE admin (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
