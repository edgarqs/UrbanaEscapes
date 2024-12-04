DROP DATABASE IF EXISTS urbanaescapes;
CREATE DATABASE IF NOT EXISTS urbanaescapes;
USE urbanaescapes;

CREATE TABLE hotel (
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
    tipus ENUM('estandar', 'suite', 'adaptada', 'deluxe') NOT NULL,
    llits ENUM('1','2','3','4') NOT NULL,
    llits_supletoris ENUM('0','1','2') NOT NULL,
    preu DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id)
);

CREATE TABLE serveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    preu DECIMAL(10, 2) NOT NULL
);

CREATE TABLE servei_habitacio (
    habitacio_id INT NOT NULL,
    servei_id INT NOT NULL,
    FOREIGN KEY (habitacio_id) REFERENCES habitacions(id),
    FOREIGN KEY (servei_id) REFERENCES serveis(id)
);

CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE reserves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    habitacio_id INT NOT NULL,
    usuari_id INT NOT NULL,
    data_entrada DATE NOT NULL,
    data_sortida DATE NOT NULL,
    preu_total DECIMAL(10, 2) NOT NULL,
    estat ENUM('lliure', 'ocupada', 'pendent') NOT NULL,
    FOREIGN KEY (habitacio_id) REFERENCES habitacions(id),
    FOREIGN KEY (usuari_id) REFERENCES usuaris(id)
);
