CREATE DATABASE db_cantina CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_cantina;

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL UNIQUE
);

CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    unidade VARCHAR(10) NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL DEFAULT 0,
    preco DECIMAL(10,2) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id)
);

INSERT INTO categoria (nome) VALUES ('Salgado'), ('Bebida'), ('Doce');

INSERT INTO produto (nome, unidade, quantidade, preco, id_categoria) VALUES 
('Coxinha de Frango', 'un', 50, 6.50, 1),
('Refrigerante Lata', 'un', 100, 5.00, 2),
('Brigadeiro', 'un', 80, 2.50, 3);