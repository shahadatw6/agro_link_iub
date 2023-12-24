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
('Tasdir', '01947585773', 'sales','4', 'mdshamims@gmail.com','tasdir', '123'),
('Faiyaz', '01832585773', 'delivery boy','5', 'faiyaz@gmail.com','faiyaz', '1234');


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
('Rice', 'Bangladesh', 200, '2023-01-15', '2024-01-15', 'Large', 5.0, 'images\\new data\\product\\1.Rice.jpeg', 'Grains', 3.99, 'High-quality rice from local farms.'), 
('Mango', 'Bangladesh', 150, '2023-03-01', '2023-08-31', 'Medium', 0.3, 'images\\new data\\product\\2.Mango.jpg', 'Fruits', 1.99, 'Fresh and juicy mangoes harvested in season.');



CREATE TABLE ORDER_TABLE (
    order_ID INTEGER,
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

ALTER TABLE product
DROP COLUMN product_Size;

ALTER TABLE FARMER
ADD COLUMN status TINYINT DEFAULT 1 NOT NULL; 

ALTER TABLE ORDER_TABLE
ADD COLUMN order_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE ORDER_TABLE
MODIFY COLUMN product_ID INTEGER NOT NULL;

ALTER TABLE consumer
ADD COLUMN status TINYINT DEFAULT 1 NOT NULL; 

ALTER TABLE order_table
ADD COLUMN order_Status TEXT NOT NULL; 

ALTER TABLE EMPLOYEE
ADD COLUMN status TINYINT DEFAULT 1 NOT NULL; 


CREATE TABLE DELIVERY (
    delivery_ID INTEGER AUTO_INCREMENT,
    delivery_date DATE NOT NULL,
    Tregistration_no VARCHAR(50),
    delivery_empID INTEGER,
    warehouse_ID INTEGER,
    consumer_ID INTEGER,
    CONSTRAINT deliveryPK PRIMARY KEY (delivery_ID),
    CONSTRAINT fk_delivery_empID FOREIGN KEY (delivery_empID) REFERENCES EMPLOYEE(employee_ID),
    CONSTRAINT fk_delivery_warehouse FOREIGN KEY (warehouse_ID) REFERENCES WAREHOUSE(warehouse_ID),
    CONSTRAINT fk_delivery_consumer FOREIGN KEY (consumer_ID) REFERENCES CONSUMER(consumer_ID)
);


ALTER TABLE ORDER_TABLE
ADD COLUMN delivery_ID INTEGER,
ADD CONSTRAINT fk_order_delivery FOREIGN KEY (delivery_ID) REFERENCES DELIVERY(delivery_ID);

INSERT INTO EMPLOYEE(emp_name, emp_contact, department, usertype, email, username, password)
VALUES ('Tausia', '0123456789', 'delivery', 4, 'delivery@example.com', 'delivery_user', 'delivery_password');

INSERT INTO EMPLOYEE(emp_name, emp_contact, department, usertype, email, username, password)
VALUES ('Anika', '9876543210', 'WAREHOUSE', 2, 'anika@example.com', 'anika', '11234');

INSERT INTO WAREHOUSE(warehouse_Capacity, freezer, silos, warehouse_location, warehouse_emp_ID)
VALUES (5000, 2, 5, 'Dhaka Warehouse', 1);

INSERT INTO EMPLOYEE(emp_name, emp_contact, department,usertype, email, username,password) VALUES
('aman', '01877585773', 'delivery', '5','aman@gmail.com','shamanahal', '123'),
('zaman', '01947585773', 'delivery','5', 'zamans@gmail.com','zaman', '123');

ALTER TABLE ORDER_TABLE
MODIFY COLUMN order_ID INTEGER AUTO_INCREMENT;


ALTER TABLE order_table
MODIFY delivery_ID INTEGER NULL;

-- Insert data into DELIVERY table
INSERT INTO DELIVERY(delivery_date, Tregistration_no, delivery_empID, warehouse_ID, consumer_ID)
VALUES ('2023-12-17', 'Dhaka Metro L - 23458', 1, 1, 1);

-- Insert data into ORDER_TABLE table
INSERT INTO ORDER_TABLE(order_Date, shipping_Mode, consumer_ID, product_ID, delivery_ID, order_Status)
VALUES ('2023-12-17 08:00:00', 'Express', 1, 1, 1, 'Pending');


-- Insert data into DELIVERY table
INSERT INTO DELIVERY(delivery_date, Tregistration_no, delivery_empID, warehouse_ID, consumer_ID)
VALUES ('2023-12-17', 'Dhaka Metro L - 23458', 1, 1, 1);
