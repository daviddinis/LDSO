DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS cards CASCADE;
DROP TABLE IF EXISTS items CASCADE;
DROP TABLE IF EXISTS companies CASCADE;
DROP TABLE IF EXISTS cars CASCADE;


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
  company INTEGER REFERENCES companies NOT NULL,
  remember_token VARCHAR
);

CREATE TABLE cards (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  user_id INTEGER REFERENCES users NOT NULL
);

CREATE TABLE items (
  id SERIAL PRIMARY KEY,
  card_id INTEGER NOT NULL REFERENCES cards ON DELETE CASCADE,
  description VARCHAR NOT NULL,
  done BOOLEAN NOT NULL DEFAULT FALSE
);



CREATE TABLE cars (
    id SERIAL PRIMARY KEY,
    brand VARCHAR NOT NULL,
    model VARCHAR NOT NULL,
    license_plate VARCHAR NOT NULL,
    company_id INTEGER NOT NULL REFERENCES companies ON DELETE CASCADE,
    date_acquired DATE NOT NULL,
    image VARCHAR, -- optional
    value FLOAT, -- optional
    kilometers INTEGER -- optional
);



INSERT INTO companies VALUES(
  DEFAULT,
  'FEUP',
  'dummyCompany',
  'dummy@company.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
);

INSERT INTO users VALUES (
  DEFAULT,
  'John Doe',
  'john@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  1
); -- Password is 1234. Generated using Hash::make('1234')


INSERT INTO cars VALUES(
  DEFAULT,
  'TOYOTA',
  'celica',
  '24-aa-11',
  1,
  '10/10/10'
)