-----------------------------------------
-- Drop
-----------------------------------------
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS items CASCADE;
DROP TABLE IF EXISTS companies CASCADE;
DROP TABLE IF EXISTS cars CASCADE;
DROP TABLE IF EXISTS taxes CASCADE;
DROP TABLE IF EXISTS insurances CASCADE;
DROP TABLE IF EXISTS inspections CASCADE;
DROP TABLE IF EXISTS maintenances CASCADE;
DROP TABLE IF EXISTS drivers CASCADE;
DROP TABLE IF EXISTS car_driver CASCADE;

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE companies (
    id SERIAL PRIMARY KEY,
    company_name VARCHAR NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    password VARCHAR NOT NULL,
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE,
    remember_token VARCHAR
);

CREATE TABLE cars (
    id SERIAL PRIMARY KEY,
    date_acquired DATE NOT NULL,
    make VARCHAR NOT NULL,
    model VARCHAR NOT NULL,
    license_plate VARCHAR NOT NULL,
    yellow_alert INTEGER DEFAULT 30,
    red_alert INTEGER DEFAULT 15,
    image VARCHAR, -- optional
    value FLOAT, -- optional
    kilometers INTEGER, -- optional
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE
);

CREATE TABLE taxes (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT NOT NULL,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE insurances (
    id SERIAL PRIMARY KEY NOT NULL,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT NOT NULL,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE inspections (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT, -- optional
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE maintenances (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    kilometers INTEGER NOT NULL,
    value FLOAT NOT NULL,
    next_maintenance_date DATE,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE drivers (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    email VARCHAR, -- optional
    drivers_license VARCHAR, -- optional
    id_card INTEGER, -- optional
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE
);

CREATE TABLE car_driver (
    id SERIAL PRIMARY KEY,
    start_date DATE NOT NULL,
    end_date DATE, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE,
    driver_id INTEGER NOT NULL REFERENCES drivers ON DELETE CASCADE
);

-----------------------------------------
-- Insert
-----------------------------------------

INSERT INTO companies (company_name) VALUES ('FEUP');
INSERT INTO companies (company_name) VALUES ('FEUP2');
INSERT INTO users (name, email, password, company_id) VALUES ('John Doe', 'johndoe@fe.up.pt', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
 1); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2000-01-01', 'AUDI', 'A1', '1234AB', NULL, NULL, 10000, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2002-02-01', 'AUDI', 'A2', '12BBBB', NULL, NULL, 50000, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2003-03-01', 'AUDI', 'A3', '13GGGG', NULL, NULL, 50000, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2004-04-01', 'AUDI', 'A4', '13XXZA', NULL, NULL, 50000, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2005-05-01', 'AUDI', 'A5', '32AAAA', NULL, NULL, 50000, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2006-06-01', 'BMW', 'M3', '44AAAA', NULL, NULL, 312313, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2007-02-01', 'BMW', 'M3', '86FFFF', NULL, NULL, 4422, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2008-01-01', 'Saab', '95', '65HGH', NULL, NULL, 4113, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2009-06-01', 'Volvo', 'V60', '66HJYU', NULL, NULL, 4555, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2010-08-01', 'Peugeot', '208', '76JJHH', NULL, NULL, 32131, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2011-09-01', 'VOLVO', 'XC90', '1ABBA', NULL, NULL, 32131, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2012-07-21', 'Peugeot', '308', '1zxczc', NULL, NULL, 31231, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2013-10-20', 'Peugeot', '308', '1234AB', NULL, NULL, 213, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2014-05-05', 'Mercedes', 'A', '1234AB', NULL, NULL, 43235, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2015-11-07', 'Mercedes', 'B', '1234AB', NULL, NULL, 4324326, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2016-12-06', 'Mercedes', 'C', '1234AB', NULL, NULL, 43633, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2017-03-04', 'Mercedes', 'D', '1234AB', NULL, NULL, 8354333, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2020-03-02', 'Mercedes', 'E', '1234AB', NULL, NULL, 7343, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1990-03-03', 'Mercedes', 'F', '1234AB', NULL, NULL, 23433, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1991-05-09', 'Mercedes', 'G', '1234AB', NULL, NULL, 4133, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1992-06-10', 'Volvo', 'S40', '1234AB', NULL, NULL, 536474, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1993-01-16', 'Volvo', 'S90', '11YYTT', NULL, NULL, 3131, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1994-01-27', 'Polestar', '1', '1234AB', NULL, NULL, 11111, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1995-01-15', 'Polestar', '1', '43FGFG', NULL, NULL, 3131, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1996-01-05', 'Polestar', '2', '99AAVV', NULL, NULL, 13156, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1997-10-01', 'Polestar', '3', '65JHGG', NULL, NULL, 4252, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1998-11-01', 'Volkswagen', 'Passat', '1234AB', NULL, NULL, 3131, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('1999-12-01', 'Volkswagen', 'Polo', '55GGFF', NULL, NULL, 2222, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2015-09-01', 'Volkswagen', 'Polo', '1234AB', NULL, NULL, 31231, 1);
INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2016-05-01', 'Volkswagen', 'Polo', '1234AB', NULL, NULL, 13131, 1);


INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-01-01', 20000, 2000.00, '2020-02-01', NULL, 'Repair', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-02-01', 20000, 2000.00, '2020-03-01', NULL, 'Monthly fees', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-03-01', 20000, 2000.00, '2020-04-01', NULL, 'Tires', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-04-01', 20000, 2000.00, '2020-05-01', NULL, 'Gas', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-05-01', 20000, 2000.00, '2020-06-01', NULL, 'Test', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-06-01', 20000, 2000.00, '2020-07-01', NULL, 'Fix break lights', 1);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-07-01', 20000, 2000.00, '2020-08-01', NULL, 'Steering', 1);

INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-01-01', 20000, 2000.00, '2020-02-01', NULL, 'Repair', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-02-01', 20000, 2000.00, '2020-03-01', NULL, 'Monthly fees', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-03-01', 20000, 2000.00, '2020-04-01', NULL, 'Tires', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-04-01', 20000, 2000.00, '2020-05-01', NULL, 'Gas', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-05-01', 20000, 2000.00, '2020-06-01', NULL, 'Test', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-06-01', 20000, 2000.00, '2020-07-01', NULL, 'Fix break lights', 2);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-07-01', 20000, 2000.00, '2020-08-01', NULL, 'Steering', 2);

INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-01-01', 20000, 2000.00, '2020-02-01', NULL, 'Repair', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-02-01', 20000, 2000.00, '2020-03-01', NULL, 'Monthly fees', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-03-01', 20000, 2000.00, '2020-04-01', NULL, 'Tires', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-04-01', 20000, 2000.00, '2020-05-01', NULL, 'Gas', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-05-01', 20000, 2000.00, '2020-06-01', NULL, 'Test', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-06-01', 20000, 2000.00, '2020-07-01', NULL, 'Fix break lights', 3);
INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-07-01', 20000, 2000.00, '2020-08-01', NULL, 'Steering', 3);

INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 1);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 2);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 3);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 4);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 5);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 6);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 7);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 8);
INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-11-21', 1234.56, NULL, NULL, 9);



INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 1);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 2);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 3);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 4);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 5);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 7);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 8);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 9);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 10);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 11);
INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 12);


INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 1);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 2);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 3);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 4);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 5);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 6);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 7);
INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 8);


INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Jane Doe', 'jane.doe@fe.up.pt', 123456789, 1, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('John Doe', 'john.doe@fe.up.pt', 123456789, 3, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Walter',   'ww@mail.com', 123456789, 16, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Michelle', 'michelle@gmail.com', 123456789, 12, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Olof', 'olafolafsson@gmail.com', 123456789, 6, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Arne', 'arang@outlook.com', 123456789, 19, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Sten', 'stenen@gmail.com', 123456789, 6, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Patrick', 'p@outlook.com', 123456789, 19, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Gunn', 'gunnarsson@gmail.com', 123456789, 6, 1);
INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Ivar', 'benlos@outlook.com', 123456789, 19, 1);


INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-10-10', 1, 1);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-11-02', 2, 2);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-01-01', '2019-12-02', 3, 3);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2018-05-01', '2018-07-02', 4, 4);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-12-31', 5, 5);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-12-31', '2020-05-02', 6, 6);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-07-01', '2020-01-02', 7, 7);

INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-02-21', '2019-03-06', 1, 2);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-08-29', '2019-09-05', 1, 3);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-03-25', 1, 4);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-05-30', '2020-10-06', 1, 5);


INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-01-01', '2019-05-10', 2, 1);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-08-29', '2019-09-05', 2, 3);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-03-25', 2, 4);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-05-30', '2020-10-06', 2, 1);


INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-01-01', '2019-05-10', 3, 1);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-02-21', '2019-03-06', 3, 2);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', '2020-03-25', 3, 4);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-05-30', '2020-10-06', 3, 1);


INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-01-01', '2019-05-10', 4, 1);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-02-21', '2019-03-06', 4, 2);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2019-08-29', '2019-09-05', 4, 3);
INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-05-30', '2020-10-06', 4, 1);