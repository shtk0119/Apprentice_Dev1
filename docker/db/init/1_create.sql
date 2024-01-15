CREATE DATABASE sample;
use sample;

CREATE TABLE users (
  id INT(11) AUTO_INCREMENT NOT NULL,
  name VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO users (id, name) VALUES (1, 'hirose');
INSERT INTO users (id, name) VALUES (2, 'shigeta');
INSERT INTO users (id, name) VALUES (3, 'shingawa');