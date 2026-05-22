-- ============================================
-- CREATE DATABASE
-- ============================================
CREATE DATABASE IF NOT EXISTS dainty_dream;
USE dainty_dream;

-- ============================================
-- MASTER TABLES
-- ============================================

-- USER (ONLY ADMIN)
CREATE TABLE m_users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE m_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE m_suppliers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    city VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE m_customers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    city VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE m_products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(100) UNIQUE,
    name VARCHAR(255),
    category_id BIGINT UNSIGNED,
    supplier_id BIGINT UNSIGNED,
    condition_status VARCHAR(50), -- e.g. like new, good, worn
    price DECIMAL(10,2),
    stock INT DEFAULT 0,

    FOREIGN KEY (category_id) REFERENCES m_categories(id),
    FOREIGN KEY (supplier_id) REFERENCES m_suppliers(id)
);

-- ============================================
-- TRANSACTION TABLES
-- ============================================

CREATE TABLE t_incoming_transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED,
    supplier_id BIGINT UNSIGNED,
    quantity INT,
    transaction_date DATE,

    FOREIGN KEY (product_id) REFERENCES m_products(id),
    FOREIGN KEY (supplier_id) REFERENCES m_suppliers(id)
);

CREATE TABLE t_outgoing_transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED,
    customer_id BIGINT UNSIGNED,
    quantity INT,
    transaction_date DATE,

    FOREIGN KEY (product_id) REFERENCES m_products(id),
    FOREIGN KEY (customer_id) REFERENCES m_customers(id)
);

-- ============================================
-- DEFAULT DATA
-- ============================================

-- ONLY ADMIN
INSERT INTO m_users (name,email,password,phone) VALUES
('Admin','admin@dainty.com','123','08123456789');

INSERT INTO m_categories (name) VALUES
('T-Shirt'),('Jacket'),('Pants');

INSERT INTO m_suppliers (name,city,phone) VALUES
('Thrift Supplier','Surabaya','082233445566');

INSERT INTO m_products (sku,name,category_id,supplier_id,condition_status,price,stock) VALUES
('SKU001','Vintage T-Shirt',1,1,'Like New',75000,10);

INSERT INTO m_customers (name,city,phone) VALUES
('Budi','Surabaya','081298765432');