--! DROP TABLES
DROP TABLE IF EXISTS evenements;
DROP TABLE IF EXISTS programmes;
DROP TABLE IF EXISTS users;

--TODO : CREATE TABLES
CREATE TABLE evenements(
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(1024) NOT NULL,
    lieu VARCHAR(2048),
    date DATE,
    programme VARCHAR(255),
    nbAimeEtu INT,
    nbNeutreEtu INT,
    nbDetesteEtu INT,
    nbAimeEmp INT,	
    nbNeutreEmp INT,
    nbDetesteEmp INT,
    PRIMARY KEY(id)
);

CREATE TABLE programmes(
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(2048) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    admin BOOLEAN NOT NULL,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(4096) NOT NULL,
    PRIMARY KEY(id) 
);