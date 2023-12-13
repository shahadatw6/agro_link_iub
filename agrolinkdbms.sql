CREATE TABLE EMPLOYEE (
    employee_ID INTEGER AUTO_INCREMENT,
    emp_name VARCHAR(100) NOT NULL,
    emp_contact VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    CONSTRAINT empPK PRIMARY KEY (employee_ID)

);

INSERT INTO EMPLOYEE(emp_name, emp_contact, department, email) VALUES
('Shahal', '01877585773', 'admin', 'shahadatw6@gmail.com'),
('Md. Shamim', '01947585773', 'sales', 'mdshamims@gmail.com');

CREATE TABLE CONSUMER (
    consumer_ID INTEGER AUTO_INCREMENT,
    consumer_name VARCHAR(100) NOT NULL, 
    consumer_contact VARCHAR(20) NOT NULL,
    road VARCHAR(100),
    district VARCHAR(50),
    house_no VARCHAR(20),
    CONSTRAINT consPK PRIMARY KEY (consumer_ID)
);

INSERT INTO CONSUMER(consumer_name, consumer_contact, road, district, house_no) VALUES
('Shahal', '01877585773', 'Banani', 'Dhaka', 'H-208'),
('Md. Tasdir', '01947585773', 'Uttara', 'Dhaka', 'H-208');

CREATE TABLE PRODUCT (
    product_ID INTEGER AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    product_Origin VARCHAR(50) NOT NULL,
    availability INTEGER NOT NULL,
    dateAdded DATE NOT NULL,
    bestBefore DATE,
    product_Size VARCHAR(20),
    weight DECIMAL(10, 2),
    CONSTRAINT product_PK PRIMARY KEY (product_ID)
);

INSERT INTO PRODUCT(product_name, product_Origin, availability, dateAdded, bestBefore, product_Size, weight) VALUES
('Rice', 'Bangladesh', 200, '2023-01-15', '2024-01-15', 'Large', 5.0),
('Mango', 'Bangladesh', 150, '2023-03-01', '2023-08-31', 'Medium', 0.3);


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
    farmer_ID INTEGER,
    farmer_Name VARCHAR(100) NOT NULL, 
    farmer_contact VARCHAR(20) NOT NULL, 
    farmer_location VARCHAR(100) NOT NULL,
    warehouse_ID INTEGER,
    CONSTRAINT farmerPK PRIMARY KEY (farmer_ID),
    CONSTRAINT fk_farmer_warehouse FOREIGN KEY (warehouse_ID) REFERENCES WAREHOUSE(warehouse_ID)
);

CREATE TABLE VEHICLE_REGISTRATION (
    Registration_ID INTEGER,
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
