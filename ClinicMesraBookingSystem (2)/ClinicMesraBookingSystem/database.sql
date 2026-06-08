CREATE DATABASE IF NOT EXISTS ClinicMesraBookingSystem;
USE ClinicMesraBookingSystem;


CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    ic_number VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT,
    password VARCHAR(255) NOT NULL,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('patient','admin') DEFAULT 'patient'
);


CREATE TABLE doctors (
    doctor_id INT PRIMARY KEY AUTO_INCREMENT,
    doctor_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    qualification VARCHAR(200),
    contact VARCHAR(15),
    email VARCHAR(100),
    status ENUM('active','inactive') DEFAULT 'active'
);

CREATE TABLE schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    doctor_id INT,
    schedule_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    max_patients INT DEFAULT 10,
    status ENUM('available','full','cancelled') DEFAULT 'available',
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);


CREATE TABLE appointments (
    appointment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    doctor_id INT,
    schedule_id INT,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    remarks TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE,
    FOREIGN KEY (schedule_id) REFERENCES schedules(schedule_id) ON DELETE CASCADE
);


INSERT INTO doctors (doctor_name, specialization, qualification, contact, email) VALUES
('Dr. Ahmad Fauzi', 'General Practitioner', 'MBBS (UM)', '012-9876543', 'dr.ahmad@clinicmesra.com'),
('Dr. Sarah Lim', 'Pediatrician', 'MBBS, MMed (Pediatrics)', '012-8765432', 'dr.sarah@clinicmesra.com'),
('Dr. Rajesh Kumar', 'Cardiologist', 'MD, DM (Cardiology)', '012-7654321', 'dr.rajesh@clinicmesra.com');


INSERT INTO users (ic_number, full_name, email, phone, address, password, role) 
VALUES ('000000-00-0000', 'Administrator', 'admin@clinicmesra.com', '012-3456789', 'Clinic Mesra', '$2a$12$Tr1aSpxGzW/1AQz6Hp0z7.CRsWJTi2Y0qs9BVN6Bo9dybyBzJN43q', 'admin');