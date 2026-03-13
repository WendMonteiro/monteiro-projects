CREATE DATABASE ads_vendas;

use ads_vendas;

CREATE TABLE if NOT EXISTS usuarioConta (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomeUsuario VARCHAR(30) NOT NULL,
    usuario VARCHAR(20) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo int
);

CREATE TABLE if NOT EXISTS cliente (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(20) NOT NULL,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(50),
    bairro VARCHAR(40),
    cidade VARCHAR(30),
    telefone VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS produto (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cod_barras VARCHAR(15) NOT NULL,
    fornecedor VARCHAR(20),
    nome_produto VARCHAR(30),
    descricao VARCHAR(50),
    preco decimal(10, 2),
    quant INT
);

CREATE TABLE IF NOT EXISTS vendas (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_cliente INT NOT NULL,
    tipo_venda INT,
    total_venda decimal(10, 2),
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE itens_vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

/*RELACIONAR USUARIO AO VENDAS*/
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_usuario FOREIGN KEY (id_usuario) REFERENCES usuarioConta (id) ON DELETE CASCADE ON UPDATE CASCADE;

/*RELACIONAR CLIENTE AO VENDAS*/
ALTER TABLE vendas ADD CONSTRAINT fk_vendas_cliente FOREIGN KEY (id_cliente) REFERENCES cliente (id) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_vendas FOREIGN KEY (id_venda) REFERENCES vendas(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE itens_vendas ADD CONSTRAINT fk_itens_produto FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE ON UPDATE CASCADE;
