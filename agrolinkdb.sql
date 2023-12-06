SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;



CREATE TABLE EMPLOYEE (
    employee_ID INTEGER AUTO_INCREMENT,
    emp_name VARCHAR(100) NOT NULL,
    emp_contact VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    usertype INTEGER NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT empPK PRIMARY KEY (employee_ID)
);

INSERT INTO EMPLOYEE(emp_name, emp_contact, department,usertype, email, username,password) VALUES
('Shahal', '01877585773', 'admin', '0','shahadatw6@gmail.com','shahal', '123'),
('Tasdir', '01947585773', 'sales','4', 'mdshamims@gmail.com','tasdir', '123');


CREATE TABLE CONSUMER (
    consumer_ID INTEGER AUTO_INCREMENT,
    consumer_name VARCHAR(100) NOT NULL, 
    consumer_contact VARCHAR(20) NOT NULL,
    road VARCHAR(100),
    district VARCHAR(50),
    house_no VARCHAR(20),
    username VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT consPK PRIMARY KEY (consumer_ID)
);

INSERT INTO CONSUMER(consumer_name, consumer_contact, road, district, house_no , username,password) VALUES
('Shahal', '01877585773', 'Banani', 'Dhaka', 'H-208','shahal', '123'),
('Md. Tasdir', '01947585773', 'Uttara', 'Dhaka', 'H-208','tasdir', '123');

CREATE TABLE PRODUCT (
    product_ID INTEGER AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    product_Origin VARCHAR(50) NOT NULL,
    availability INTEGER NOT NULL,
    dateAdded DATE NOT NULL,
    bestBefore DATE,
    product_Size VARCHAR(20),
    weight DECIMAL(10, 2),
    imagelink VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    unitprice DECIMAL(10, 2),
    description VARCHAR(200),
    CONSTRAINT product_PK PRIMARY KEY (product_ID)
);

INSERT INTO PRODUCT (product_name, product_Origin, availability, dateAdded, bestBefore, product_Size, weight, imagelink, category, unitprice, description) VALUES 
('Rice', 'Bangladesh', 200, '2023-01-15', '2024-01-15', 'Large', 5.0, 'images\\new data\\shahal.jpg', 'Grains', 3.99, 'High-quality rice from local farms.'), 
('Mango', 'Bangladesh', 150, '2023-03-01', '2023-08-31', 'Medium', 0.3, 'images\\new data\\tasdir.jpg', 'Fruits', 1.99, 'Fresh and juicy mangoes harvested in season.');



CREATE TABLE ORDER_TABLE (
    order_ID INTEGER,
    order_Date DATE NOT NULL,
    shipping_Mode VARCHAR(20) NOT NULL,
    consumer_ID INTEGER,
    product_ID INTEGER,
    CONSTRAINT orderPK PRIMARY KEY (order_ID),
    CONSTRAINT fk_consumer FOREIGN KEY (consumer_ID) REFERENCES CONSUMER(consumer_ID),
    CONSTRAINT fk_product FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID)
);


CREATE TABLE WAREHOUSE (
    warehouse_ID INTEGER AUTO_INCREMENT,
    warehouse_Capacity INTEGER NOT NULL,
    freezer INTEGER,
    silos INTEGER,
    warehouse_location VARCHAR(100) NOT NULL,
    warehouse_emp_ID INTEGER,
    CONSTRAINT warehousePK PRIMARY KEY (warehouse_ID),
    CONSTRAINT fk_warehouse_empID FOREIGN KEY (warehouse_emp_ID) REFERENCES EMPLOYEE(employee_ID)
);


CREATE TABLE FARMER (
    farmer_ID INTEGER AUTO_INCREMENT,
    farmer_Name VARCHAR(100) NOT NULL, 
    farmer_contact VARCHAR(20) NOT NULL, 
    username VARCHAR(15) NOT NULL,
    farmer_location VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT farmerPK PRIMARY KEY (farmer_ID)
);

INSERT INTO FARMER (farmer_Name, farmer_contact, farmer_location,username, password) VALUES
('Rahim Khan', '01876543210', 'Dhaka','rahim', '1234'),
('Ayesha Begum', '01987654321', 'Sylhet','ayesha', '1234'),
('Kamal Ahmed', '01712345678', 'Chittagong','kamal', '1234');


CREATE TABLE VEHICLE_REGISTRATION (
    Registration_ID VARCHAR(50),
    model_no VARCHAR(50) NOT NULL,
    capacity INTEGER NOT NULL,
    delivery_Officer_emp_ID INTEGER,
    delivery_Time TIME,
    CONSTRAINT registrationPK PRIMARY KEY (Registration_ID)
); 

INSERT INTO VEHICLE_REGISTRATION(Registration_ID,model_no, capacity, delivery_Officer_emp_ID, delivery_Time) VALUES

('Dhaka Metro L - 23455', 'Ford ', 5, 101, '12:30:00'),
('Dhaka Metro L - 23456', 'Eicher', 8, 102, '14:45:00'),
('Dhaka Metro L - 23457', 'Mitsubishi', 7, 103, '11:15:00');




CREATE TABLE TRANSACTION (
    Transaction_ID INTEGER,
    payment_amount DECIMAL(12, 2),
    pending BOOLEAN,
    completed BOOLEAN,
    failed BOOLEAN,
    employee_ID INTEGER,
    order_ID INTEGER,
    farmer_ID INTEGER,
    CONSTRAINT transactionPK PRIMARY KEY (Transaction_ID),
    CONSTRAINT fk_transaction_employee FOREIGN KEY (employee_ID) REFERENCES EMPLOYEE(employee_ID),
    CONSTRAINT fk_transaction_order FOREIGN KEY (order_ID) REFERENCES ORDER_TABLE(order_ID),
    CONSTRAINT fk_transaction_farmer FOREIGN KEY (farmer_ID) REFERENCES FARMER(farmer_ID)
);


CREATE TABLE CART (
    cart_ID INTEGER AUTO_INCREMENT,
    product_ID INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    consumer_ID INTEGER,
    PRIMARY KEY (cart_ID),
    CONSTRAINT fk_cart_product FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID),
    CONSTRAINT fk_cart_consumer FOREIGN KEY (consumer_ID) REFERENCES CONSUMER(consumer_ID)
);


ALTER TABLE PRODUCT
ADD COLUMN added_by INT,
ADD CONSTRAINT fk_added_by FOREIGN KEY (added_by) REFERENCES farmer(farmer_id);


ALTER TABLE PRODUCT
ADD COLUMN status TINYINT DEFAULT 1 NOT NULL;
