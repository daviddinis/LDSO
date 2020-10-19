-----------------------------------------
-- Drop
-----------------------------------------
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS cards CASCADE;
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
    company_name VARCHAR NOT NULL,
    name VARCHAR NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    password VARCHAR NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    password VARCHAR NOT NULL,
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE,
    remember_token VARCHAR
);

--------------------- REMOVE LATER -------------------------------
CREATE TABLE cards (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users ON DELETE CASCADE
);

CREATE TABLE items (
    id SERIAL PRIMARY KEY,
    card_id INTEGER NOT NULL REFERENCES cards ON DELETE CASCADE,
    description VARCHAR NOT NULL,
    done BOOLEAN NOT NULL DEFAULT FALSE
);
------------------------------------------------------------------

CREATE TABLE cars (
    id SERIAL PRIMARY KEY,
    date_acquired DATE NOT NULL,
    make VARCHAR NOT NULL,
    model VARCHAR NOT NULL,
    license_plate VARCHAR NOT NULL,
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

INSERT INTO companies (company_name, name, email, password) VALUES ('FEUP', 'FEUP', 'feup@fe.up.pt', 'feup123');

INSERT INTO users (name, email, password, company_id) VALUES ('John Doe', 'johndoe@fe.up.pt', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
 1); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO cars (date_acquired, make, model, license_plate, image, value, kilometers, company_id) VALUES ('2000-01-01', 'AUDI', 'A3', '1234AB', NULL, NULL, NULL, 1);

INSERT INTO taxes (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 1);

INSERT INTO insurances (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', 1234.56, NULL, NULL, 1);

INSERT INTO inspections (date, expiration_date, value, file, obs, car_id) VALUES ('2020-01-01', '2020-12-31', NULL, NULL, NULL, 1);

INSERT INTO maintenances (date, kilometers, value, next_maintenance_date, file, obs, car_id) VALUES ('2020-01-01', 20000, 2000.00, NULL, NULL, NULL, 1);

INSERT INTO drivers (name, email, drivers_license, id_card, company_id) VALUES ('Jane Doe', NULL, NULL, NULL, 1);

INSERT INTO car_driver (start_date, end_date, car_id, driver_id) VALUES ('2020-01-01', NULL, 1, 1);
