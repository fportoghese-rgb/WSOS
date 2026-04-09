-- Creazione database
CREATE DATABASE IF NOT EXISTS offersdb;
USE offersdb;

-- Creazione tabella
CREATE TABLE IF NOT EXISTS offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    validita DATE,
    acquistato INT DEFAULT 0
);

-- Inserimento dati di esempio
INSERT INTO offers (descrizione, prezzo, validita, acquistato) VALUES
('Offerta Natale', 19.99, '2025-12-25', 0),
('Sconto Estivo', 29.50, '2025-08-31', 5),
('Promozione Black Friday', 49.90, '2025-11-28', 10),
('Offerta Weekend', 15.00, '2025-11-15', 2),
('Speciale Primavera', 25.75, '2026-03-20', 0);
