CREATE DATABASE prjwaems CHARACTER SET utf8 COLLATE utf8_general_ci;
USE prjwaems;


CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_position INT NOT NULL,
    id_department INT NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_position) REFERENCES positions(id),
    FOREIGN KEY (id_department) REFERENCES departments(id)
);

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE history_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_employee_changed INT NOT NULL,
    id_employee_author INT NOT NULL,
    action_type ENUM('create', 'update', 'delete') NOT NULL,
    description TEXT NOT NULL,
    datetime DATETIME NOT NULL,
    FOREIGN KEY (id_employee_changed) REFERENCES employees(id),
    FOREIGN KEY (id_employee_author) REFERENCES employees(id)
);
