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
    id_hotel INT NOT NULL,
    tipus ENUM('Estandar', 'Suite', 'Adaptada', 'Deluxe') NOT NULL,
    llits ENUM(1,2,3,4) NOT NULL,
    llits_supletoris ENUM(0,1,2) INT NOT NULL,
    preu DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_hotel) REFERENCES hotel(id)
);

CREATE TABLE serveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    servei VARCHAR(255) NOT NULL
);

CREATE TABLE servei_habitacio (
    id_habitacio INT NOT NULL,
    id_servei INT NOT NULL,
    FOREIGN KEY (id_habitacio) REFERENCES habitacions(id),
    FOREIGN KEY (id_servei) REFERENCES serveis(id)
);

CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE reserves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_habitacio INT NOT NULL,
    id_usuari INT NOT NULL,
    data_entrada DATE NOT NULL,
    data_sortida DATE NOT NULL,
    preu_total DECIMAL(10, 2) NOT NULL,
    estat ENUM('Pendent', 'Confirmada', 'Cancelada') NOT NULL,
    FOREIGN KEY (id_habitacio) REFERENCES habitacions(id),
    FOREIGN KEY (id_usuari) REFERENCES usuaris(id)
);
