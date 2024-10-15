-- CREATE DATABASE postgre;

DROP TABLE IF EXISTS users;

CREATE TABLE users
(
    id     SERIAL PRIMARY KEY,
    number VARCHAR(255) NOT NULL UNIQUE,
    name   VARCHAR(255) NOT NULL
);

CREATE INDEX idx_number ON users (number);

CREATE TABLE mailings
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text  TEXT         NOT NULL
);

CREATE TABLE mailing_queue
(
    id         SERIAL PRIMARY KEY,
    user_id    INT NOT NULL,
    mailing_id INT NOT NULL,
    sent       BOOLEAN DEFAULT FALSE,
    sent_at    TIMESTAMP,

    CONSTRAINT fk_user
        FOREIGN KEY (user_id)
            REFERENCES users (id)
            ON DELETE CASCADE,

    CONSTRAINT fk_mailing
        FOREIGN KEY (mailing_id)
            REFERENCES mailings (id)
            ON DELETE CASCADE
);
