-- Create database (normally done outside of SQL script in PostgreSQL)
-- CREATE DATABASE Portfolio_Management;

-- Connect to the database (This is an example command in psql client)
-- \c Portfolio_Management;

-- Create tables
CREATE TABLE user_details (
    user_id VARCHAR(12) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    pan VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(255) DEFAULT 'user'
);

CREATE TABLE phone_numbers (
    user_id VARCHAR(12),
    phone_number VARCHAR(10) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user_details(user_id)
);

CREATE TABLE company (
    stock_id VARCHAR(4) PRIMARY KEY,
    stock_name VARCHAR(255) NOT NULL,
    stock_price NUMERIC(10, 2) NOT NULL
);

CREATE TABLE watchlist (
    user_id VARCHAR(12) NOT NULL,
    stock_id VARCHAR(4),
    stock_price NUMERIC(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user_details(user_id),
    FOREIGN KEY (stock_id) REFERENCES company(stock_id)
);

CREATE TABLE portfolio (
    user_id VARCHAR(12) NOT NULL,
    buy_price INT,
    stock_id VARCHAR(4) NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (user_id, stock_id),
    FOREIGN KEY (stock_id) REFERENCES company(stock_id),
    FOREIGN KEY (user_id) REFERENCES user_details(user_id)
);

CREATE TABLE transaction (
    transaction_id SERIAL PRIMARY KEY,
    date_of_purchase DATE NOT NULL,
    user_id_purchased VARCHAR(12),
    stock_id VARCHAR(4),
    price NUMERIC(10, 2) NOT NULL,
    quantity INT NOT NULL,
    user_id_bought VARCHAR(12),
    FOREIGN KEY (user_id_purchased) REFERENCES user_details(user_id),
    FOREIGN KEY (user_id_bought) REFERENCES user_details(user_id),
    FOREIGN KEY (stock_id) REFERENCES company(stock_id)
);

CREATE TABLE company_performance (
    open_price NUMERIC(10, 2) NOT NULL,
    close_price NUMERIC(10, 2) NOT NULL,
    date DATE NOT NULL,
    lowest_price NUMERIC(10, 2) NOT NULL,
    highest_price NUMERIC(10, 2) NOT NULL,
    time TIME NOT NULL,
    stock_id VARCHAR(4) NOT NULL,
    PRIMARY KEY (stock_id, date, time),
    FOREIGN KEY (stock_id) REFERENCES company(stock_id)
);

-- Вставки и другие инициализации были бы аналогичными, но с учетом любых особенностей PostgreSQL

-- Создание триггера в PostgreSQL
CREATE OR REPLACE FUNCTION generate_username() RETURNS TRIGGER AS $$
BEGIN
    NEW.user_id := CONCAT(NEW.pan, SUBSTRING(NEW.dob::text, 3, 2));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER generate_username
BEFORE INSERT ON user_details
FOR EACH ROW
EXECUTE FUNCTION generate_username();

-- Измените таблицу user_details, чтобы добавить новый столбец (если он не был добавлен ранее)
ALTER TABLE user_details ADD COLUMN IF NOT EXISTS role VARCHAR(255) DEFAULT 'user';

-- Вставьте 5 пользователей в таблицу user_details
INSERT INTO user_details (user_id, dob, name, password, pan, email)
VALUES
('ABCDE1234G03', '2003-06-30', 'John Doe', 'password1', 'ABCDE1234G', 'john@example.com'),
('XYZTE9876R13', '2013-11-30', 'Jane Smith', 'password2', 'XYZTE9876R', 'jane@example.com'),
('PQRWF4567F03', '2003-06-30', 'Bob Johnson', 'password3', 'PQRWF4567F', 'bob@example.com'),
('LMNER2348G09', '2009-05-31', 'Alice Brown', 'password4', 'LMNER2348G', 'alice@example.com'),
('DEFRE7890K03', '2003-06-05', 'Eva Wilson', 'password5', 'DEFRE7890K', 'eva@example.com');

-- Insert phone numbers for the users
INSERT INTO phone_numbers (user_id, phone_number)
VALUES
('ABCDE1234G03', '1234567890'),
('XYZTE9876R13', '9876543210'),
('PQRWF4567F03', '5555555555'),
('LMNER2348G09', '1111111111'),
('DEFRE7890K03', '9999999999');

-- Insert 5 companies
INSERT INTO company (stock_id, stock_name, stock_price)
VALUES
('AAPL', 'Apple Inc.', 150.50),
('GOOG', 'Alphabet Inc.', 2800.00),
('MSFT', 'Microsoft Corporation', 300.75),
('AMZN', 'Amazon.com Inc.', 3400.25),
('TSLA', 'Tesla, Inc.', 650.00);

-- Insert stocks into watchlists
INSERT INTO watchlist (user_id, stock_id, stock_price)
VALUES
('ABCDE1234G03', 'AAPL', 150.50),
('XYZTE9876R13', 'GOOG', 2800.00),
('PQRWF4567F03', 'MSFT', 300.75),
('LMNER2348G09', 'AMZN', 3400.25),
('DEFRE7890K03', 'TSLA', 650.00);

-- Insert portfolios for users
INSERT INTO portfolio (user_id, buy_price, stock_id, quantity)
VALUES
('ABCDE1234G03', 3400.25, 'AMZN', 23),
('ABCDE1234G03', 2800.00, 'GOOG', 40),
('XYZTE9876R13', 2800.00, 'GOOG', 38),
('PQRWF4567F03', 300.75, 'MSFT', 69),
('LMNER2348G09', 650.00, 'TSLA', 412);

-- Insert additional companies
INSERT INTO company (stock_id, stock_name, stock_price)
VALUES
('AAP', 'Advance Auto Parts Inc.', 200.90),
('CAT', 'Caterpillar Inc.', 180.25),
('LMT', 'Lockheed Martin Corporation', 400.60),
('ABBV', 'AbbVie Inc.', 110.75),
('PEP', 'PepsiCo Inc.', 150.30);

INSERT INTO company (stock_id, stock_name, stock_price)
VALUES
('NFLX', 'Netflix Inc.', 600.80),
('BA', 'The Boeing Company', 220.10),
('PYPL', 'PayPal Holdings Inc.', 290.80),
('ORCL', 'Oracle Corporation', 85.50),
('VZ', 'Verizon Communications Inc.', 55.25),
('WMT', 'Walmart Inc.', 140.30),
('PFE', 'Pfizer Inc.', 45.60),
('XOM', 'Exxon Mobil Corporation', 65.75),
('GE', 'General Electric Company', 90.20),
('AMD', 'Advanced Micro Devices Inc.', 120.40);

-- Insert transactions
INSERT INTO transaction (date_of_purchase, user_id_purchased, stock_id, price, quantity, user_id_bought)
VALUES
('2023-10-24', 'ABCDE1234G03', 'AAPL', 150.50, 10, 'XYZTE9876R13'),
('2023-10-23', 'PQRWF4567F03', 'GOOG', 2800.00, 5, 'LMNER2348G09'),
('2023-10-22', 'XYZTE9876R13', 'MSFT', 300.75, 8, 'DEFRE7890K03'),
('2023-10-21', 'DEFRE7890K03', 'AMZN', 3400.25, 12, 'ABCDE1234G03'),
('2023-10-20', 'LMNER2348G09', 'TSLA', 650.00, 15, 'PQRWF4567F03');

-- Insert performance data for companies
INSERT INTO company_performance (open_price, close_price, date, lowest_price, highest_price, time, stock_id)
VALUES
(152.00, 150.50, '2023-10-24', 149.75, 152.50, '09:30:00', 'AAPL'),
(2802.00, 2800.00, '2023-10-24', 2798.50, 2810.25, '09:30:00', 'GOOG'),
(301.00, 300.75, '2023-10-24', 299.75, 302.25, '09:30:00', 'MSFT'),
(3405.50, 3400.25, '2023-10-24', 3399.75, 3412.00, '09:30:00', 'AMZN'),
(655.00, 650.00, '2023-10-24', 648.50, 657.25, '09:30:00', 'TSLA');

-- Insert additional performance data
INSERT INTO company_performance (open_price, close_price, date, lowest_price, highest_price, time, stock_id)
VALUES
(200.90, 201.50, '2023-11-19', 199.75, 203.20, '12:30:00', 'AAP'),
(110.75, 112.20, '2023-11-19', 109.90, 113.00, '12:30:00', 'ABBV'),
(120.40, 122.00, '2023-11-19', 119.80, 123.50, '12:30:00', 'AMD'),
(180.25, 181.00, '2023-11-19', 179.80, 183.50, '12:30:00', 'CAT'),
(90.20, 91.00, '2023-11-19', 89.80, 93.50, '12:30:00', 'GE'),
(400.60, 402.00, '2023-11-19', 398.80, 403.50, '12:30:00', 'LMT'),
(150.30, 152.00, '2023-11-19', 149.80, 153.50, '12:30:00', 'PEP'),
(45.60, 47.00, '2023-11-19', 44.80, 48.50, '12:30:00', 'PFE'),
(140.30, 142.00, '2023-11-19', 138.80, 143.50, '12:30:00', 'WMT'),
(90.20, 91.00, '2023-11-19', 89.80, 93.50, '12:30:00', 'XOM');

-- Insert an admin user
INSERT INTO user_details (user_id, name, password, dob, pan, email, role)
VALUES ('admin', 'Admin', 'admin', '1990-01-01', 'ADMIN1234P', 'admin@admin.com', 'admin');
