DROP DATABASE IF EXISTS shop_db;

CREATE DATABASE shop_db;

USE shop_db;

/* Create PRODUCT_GROUP table. */

CREATE TABLE product_group (
  product_group_number INT(3) NOT NULL PRIMARY KEY,
  product_group_name VARCHAR(25) NOT NULL DEFAULT ''
  );

/* INSERT initialization data into the PRODUCT_GROUP table. */

INSERT INTO product_group (product_group_number, product_group_name) VALUES
	  (1, 'Wreaths')
	, (2, 'Artifical Plants');

/* Create PRODUCT table. */

CREATE TABLE product (
  id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(40) NOT NULL DEFAULT '',
  description VARCHAR(200) NOT NULL DEFAULT '',
  price DECIMAL(10,2) NOT NULL DEFAULT 0.0,
  product_group INT(2) NOT NULL DEFAULT 1,
  image_url VARCHAR(256) DEFAULT 'images/default-image.jpg',
  FOREIGN KEY (product_group) REFERENCES product_group (product_group_number)
  );

/* INSERT initialization data into the PRODUCT table. */

INSERT INTO product (product_name, description, price, product_group, image_url) VALUES
	  ('Straw Wreath', '40cm Straw Wreath!', 4.90, 1, 'images/strawweath.jpg')
	, ('Christmas Wreath', '45cm Christmas Base wreath', 8.50, 1, 'images/wreath.jpg')
	, ('Styrofoam Wreath', '27cm Stryofoam Wreath', 1.99, 1, 'images/swreath.jpg')
	, ('Filler Bouquet', '10 heads Green/Yellow Filler Bouquet', 2.32, 2, 'images/fillerbouquet.jpg')
	, ('Lily Filler Bouquet', 'White Lily Filler Bouquet', 1.40, 2, 'images/lilyfiller.jpg')
    , ('Purple Filler', '10 head Purple Artificial Filler', 2.32, 2, 'images/purplefiller.jpg')
	, ('Rose Bud Bouquet', '36 Flowers Green Rose Bud Bouquet', 16.42, 2, 'images/rosebud.jpg')
	, ('Eucalyptus ', 'Bouquet of Artifical Eucalyptus', 5.00, 2, 'images/eucalyptus.jpg')
	, ('Sunflower', 'Bouquet of 7 head Sunflowers', 3.90, 2, 'images/sunflower.jpg');

/* Create ORDER table. */

CREATE TABLE `order` (
  order_number INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.0
  );

/* Create ORDER_ITEM table. */

CREATE TABLE order_item (
  order_number INT(5) NOT NULL,
  order_item_number INT(5) NOT NULL,
  product_id INT(3),
  quantity INT(2),
  amount DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (order_number, order_item_number),
  FOREIGN KEY (order_number) REFERENCES `order` (order_number),
  FOREIGN KEY (product_id) REFERENCES product (id)
  );


CREATE TABLE booking_group (
  booking_group_number INT(3) NOT NULL PRIMARY KEY,
  booking_group_name VARCHAR(25) NOT NULL DEFAULT ''
  );




INSERT INTO booking_group (booking_group_number, booking_group_name) VALUES
	  (1, 'Appointments');

/* Create BOOKINGS table. */

CREATE TABLE bookings (
  bookings_id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  booking_name VARCHAR(40) NOT NULL DEFAULT '',
  bprice INT (1) NOT NULL,	
  start_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  booking_group INT(2) NOT NULL DEFAULT 1,
  FOREIGN KEY (booking_group) REFERENCES booking_group (booking_group_number)
  );

/* INSERT initialization data into the BOOKINGS table. */

INSERT INTO bookings (booking_name, start_date, booking_group) VALUES
	  ('Today 12:00', DEFAULT, 1)
	, ('Today 12:30', DEFAULT, 1)
	, ('Today 13:00', DEFAULT, 1)
	, ('Today 13:30', DEFAULT, 1)
	, ('Today 14:00', DEFAULT, 1)
        , ('Today 14:30', DEFAULT, 1)
	, ('Today 15:00', DEFAULT, 1)
	, ('Today 15:30', DEFAULT, 1)
	, ('Today 16:00', DEFAULT, 1);


CREATE TABLE `appointment` (
  appointment_number INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  appointment_date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  booking_name VARCHAR(40) NOT NULL DEFAULT '',
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.0
  );



CREATE TABLE appointment_item (
  appointment_number INT(50) NOT NULL,
  appointment_item_number INT(5) NOT NULL,
  booking_name VARCHAR(20) NOT NULL,
  bookings_id INT(3),
  bquantity INT(1),
  PRIMARY KEY (appointment_number),
  FOREIGN KEY (bookings_id) REFERENCES bookings (bookings_id)
  );
