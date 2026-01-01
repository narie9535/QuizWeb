/*datebase name "dpproject"*/

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    optA VARCHAR(255) NOT NULL,
    optB VARCHAR(255) NOT NULL,
    optC VARCHAR(255) NOT NULL,
    optD VARCHAR(255) NOT NULL,
    correct CHAR(1) NOT NULL
);


CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    score INT NOT NULL
);
