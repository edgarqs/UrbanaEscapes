DROP DATABASE IF EXISTS urbanaescapes;
CREATE DATABASE IF NOT EXISTS urbanaescapes;
USE urbanaescapes;

CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    adreca VARCHAR(255) NOT NULL,
    ciutat VARCHAR(255) NOT NULL,
    pais VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefon VARCHAR(13) NOT NULL
);

CREATE TABLE habitacions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    tipus ENUM('estandar', 'deluxe', 'suite', 'adaptada') NOT NULL,
    llits ENUM('1','2','3','4') NOT NULL,
    llits_supletoris ENUM('0','1','2') NOT NULL,
    preu DECIMAL(10, 2) NOT NULL,
    numHabitacio INT NOT NULL,
    estat ENUM('lliure', 'ocupada') NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

CREATE TABLE rols (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    rol_id INT NOT NULL,
    hotel_id INT,
    FOREIGN KEY (rol_id) REFERENCES rols(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    habitacion_id INT NOT NULL,
    usuari_id INT NOT NULL,
    data_entrada DATE NOT NULL,
    data_sortida DATE NOT NULL,
    preu_total DECIMAL(10, 2) NOT NULL,
    estat ENUM('reservada', 'checkin', 'checkout', 'cancelada') NOT NULL,
    comentaris VARCHAR(255),
    FOREIGN KEY (habitacion_id) REFERENCES habitacions(id) ON DELETE CASCADE,
    FOREIGN KEY (usuari_id) REFERENCES usuaris(id) ON DELETE CASCADE
);

CREATE TABLE serveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    preu DECIMAL(10, 2) NOT NULL
);

CREATE TABLE habitacion_serveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    habitacions_id INT NOT NULL,
    serveis_id INT NOT NULL,
    FOREIGN KEY (habitacions_id) REFERENCES habitacions(id) ON DELETE CASCADE,
    FOREIGN KEY (serveis_id) REFERENCES serveis(id) ON DELETE CASCADE
);
