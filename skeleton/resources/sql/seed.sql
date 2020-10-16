DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS cards CASCADE;
DROP TABLE IF EXISTS items CASCADE;
DROP TABLE IF EXISTS companies CASCADE;
DROP TABLE IF EXISTS cars CASCADE;


Create Table companies (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL
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
  brand VARCHAR not null,
  model VARCHAR not null,
  license_plate VARCHAR not null,
  company INTEGER REFERENCES companies NOT NULL,
  currently_using INTEGER REFERENCES users
);


INSERT INTO companies VALUES(
  DEFAULT,
  'FEUP'
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
  1
)