
-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE IF NOT EXISTS companies (
    id SERIAL PRIMARY KEY,
    company_name VARCHAR NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    password VARCHAR NOT NULL,
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE,
    remember_token VARCHAR
);

CREATE TABLE IF NOT EXISTS cars (
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

CREATE TABLE IF NOT EXISTS taxes (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT NOT NULL,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS insurances (
    id SERIAL PRIMARY KEY NOT NULL,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT NOT NULL,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS inspections (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    value FLOAT, -- optional
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS  maintenances (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    kilometers INTEGER NOT NULL,
    value FLOAT NOT NULL,
    next_maintenance_date DATE,
    file VARCHAR, -- optional
    obs VARCHAR, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS drivers (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    email VARCHAR, -- optional
    drivers_license VARCHAR, -- optional
    id_card INTEGER, -- optional
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS car_driver (
    id SERIAL PRIMARY KEY,
    start_date DATE NOT NULL,
    end_date DATE, -- optional
    car_id INTEGER NOT NULL REFERENCES cars ON DELETE CASCADE,
    driver_id INTEGER NOT NULL REFERENCES drivers ON DELETE CASCADE
);