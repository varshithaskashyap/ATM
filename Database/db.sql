
-- DROP DATABASE IF EXISTS atm;
-- CREATE DATABASE atm;
-- USE atm;

USE sql12386553;

CREATE TABLE user
(
		acc_number BIGINT primary key,
		first_name varchar(30) not null,
        last_name varchar(30) not null,
		pin varchar(100) not null,
		email varchar(30) not null,
		created_at timestamp default now()	
);


INSERT INTO user (acc_number,first_name,last_name,pin,email)
	VALUES
		(1234567890,'Test','User-1','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(2345678901,'Test','User-2','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(3456789012,'Test','User-3','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(4567890123,'Test','User-4','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(5678901234,'Test','User-5','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(6789012345,'Test','User-6','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(7890123456,'Test','User-7','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(8901234567,'Test','User-8','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(9012345678,'Test','User-9','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com'),
		(0123456789,'Test','User-10','$2y$10$C9lO7qUxM2A6U4nJ4.ECMucvqmAjzBITdwVqGWlUWRJX4ykOlDkHe','johnsmith@example.com');

CREATE TABLE transaction
(
		transaction_id int auto_increment primary key,
		acc_number BIGINT not null,
		initail_balence  BIGINT,
		transaction_amt  BIGINT,
		current_balence BIGINT,
		transaction_statement varchar(30) not null,
		created_at timestamp default now(),
		foreign key(acc_number) references user(acc_number) on delete cascade	 
);


INSERT INTO transaction (acc_number,initail_balence,transaction_amt,current_balence,transaction_statement)
		VALUES
			(1234567890,0,20000,20000,'Deposit'),
			(2345678901,0,20000,20000,'Deposit'),
			(3456789012,0,20000,20000,'Deposit'),
			(4567890123,0,20000,20000,'Deposit'),
			(5678901234,0,20000,20000,'Deposit'),
			(6789012345,0,20000,20000,'Deposit'),
			(7890123456,0,20000,20000,'Deposit'),
			(8901234567,0,20000,20000,'Deposit'),
			(9012345678,0,20000,20000,'Deposit'),
			(0123456789,0,20000,20000,'Deposit');

CREATE TABLE bills
(
	id INT auto_increment primary key,
	2000s INT DEFAULT 0,1000s INT DEFAULT 0,500s INT DEFAULT 0,
	200s INT DEFAULT 0,100s INT DEFAULT 0,50s INT DEFAULT 0,
	20s INT DEFAULT 0,10s INT DEFAULT 0,5s INT DEFAULT 0,
	foreign key(id) references transaction(transaction_id) on delete cascade	 
);


INSERT INTO bills 
	VALUES
		(1,10,10,10,10,10,10,10,10,10);