CREATE DATABASE loja_tom;

USE loja_tom;

-- TABELA DE USUÁRIOS
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- TABELA DE CLIENTES
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(255),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(200)
);

-- TABELA DE PRODUTOS
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL
);

-- TABELA DE PEDIDOS
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    data_pedido DATE NOT NULL,

    FOREIGN KEY (cliente_id)
        REFERENCES clientes(id),

    FOREIGN KEY (produto_id)
        REFERENCES produtos(id)
);

-- USUÁRIOS
-- Senha de demonstração dos três usuários: 123456
INSERT INTO usuarios (nome, email, senha) VALUES
('Administrador', 'admin@loja.com',
'$2y$10$Flpt1DJWzPNLV1g.x51WBOrWjkwJyi8WjjD84dTHwPBhg.OKZktwS'),
('Carlos', 'carlos@loja.com',
'$2y$10$Flpt1DJWzPNLV1g.x51WBOrWjkwJyi8WjjD84dTHwPBhg.OKZktwS'),
('Mariana', 'mariana@loja.com',
'$2y$10$Flpt1DJWzPNLV1g.x51WBOrWjkwJyi8WjjD84dTHwPBhg.OKZktwS');

-- CLIENTES
-- CPF inicialmente NULL; será preenchido pela aplicação, que armazena criptografado.
INSERT INTO clientes
(nome, telefone, email, endereco)
VALUES
('João Silva', '16999990001', 'joao@email.com', 'Rua A, 100'),
('Maria Souza', '16999990002', 'maria@email.com', 'Rua B, 200'),
('Pedro Santos', '16999990003', 'pedro@email.com', 'Rua C, 300');

-- PRODUTOS
INSERT INTO produtos
(nome, categoria, preco, estoque)
VALUES
('Notebook', 'Computadores', 3500.00, 10),
('Mouse', 'Periféricos', 80.00, 30),
('Teclado', 'Periféricos', 150.00, 20);

-- PEDIDOS
INSERT INTO pedidos
(cliente_id, produto_id, quantidade, data_pedido)
VALUES
(1, 1, 1, '2025-11-10'),
(2, 2, 2, '2026-12-12'),
(3, 3, 1, '2027-10-15');