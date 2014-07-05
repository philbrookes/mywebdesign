DROP TABLE IF EXISTS `Admin`;

CREATE TABLE `Admin` ( 
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(80) NOT NULL,
    `password` BLOB NOT NULL,
    `email`    VARCHAR(160) NOT NULL
); 

DROP TABLE IF EXISTS `Customer`;

CREATE TABLE `Customer` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(80) NOT NULL,
    `last_name` VARCHAR(80) NOT NULL,
    `email`    VARCHAR(160) NOT NULL
);

DROP TABLE IF EXISTS `Product`;

CREATE TABLE `Product` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(80) NOT NULL,
    `price` DECIMAL(8,2) UNSIGNED NOT NULL,
    `cost` DECIMAL(8,2) UNSIGNED NOT NULL,
    `repeating` INT NOT NULL
);

DROP TABLE IF EXISTS `Item`;

CREATE TABLE `Item` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(80) NOT NULL,
    `product_id` INT NOT NULL,
    `next_bill_date` TIMESTAMP NOT NULL,
    `customer_id` INT NOT NULL
);

DROP TABLE IF EXISTS `Invoice`;

CREATE TABLE `Invoice` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `issue_date` TIMESTAMP NOT NULL,
    `due_date` TIMESTAMP NOT NULL,
    `paid_date` TIMESTAMP,
    `customer_id` INT NOT NULL,
    `status` VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS `InvoiceItem`;

CREATE TABLE `InvoiceItem` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` INT NOT NULL,
    `item_id` INT NOT NULL,
    `name` VARCHAR(80),
    `amount` DECIMAL(10, 2) UNSIGNED NOT NULL
);

DROP TABLE IF EXISTS `Order`;

CREATE TABLE `Order` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date_ordered` TIMESTAMP NOT NULL,
    `first_name` VARCHAR(80) NOT NULL,
    `last_name` VARCHAR(80) NOT NULL,
    `email` VARCHAR(180) NOT NULL,
    `notes` BLOB
);