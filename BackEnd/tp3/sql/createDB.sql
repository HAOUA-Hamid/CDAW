CREATE TABLE USER (
    USER_ID INT AUTO_INCREMENT PRIMARY KEY,
    USER_LOGIN VARCHAR(50) NOT NULL UNIQUE,
    USER_EMAIL VARCHAR(100) NOT NULL,
    USER_ROLE VARCHAR(50) NOT NULL,
    USER_PWD VARCHAR(255) NOT NULL,
    USER_NAME VARCHAR(50),
    USER_SURNAME VARCHAR(50)
);

-- Optional: Insert sample data
INSERT INTO USER (USER_LOGIN, USER_EMAIL, USER_ROLE, USER_PWD, USER_NAME, USER_SURNAME)
VALUES ('john_doe', 'john@example.com', 'user', 'password123', 'John', 'Doe'),
       ('jane_smith', 'jane@example.com', 'admin', 'pass456', 'Jane', 'Smith');
       CREATE TABLE ROLE (
    ROLE_ID INT AUTO_INCREMENT PRIMARY KEY,
    ROLE_NAME VARCHAR(50) NOT NULL UNIQUE,
    ROLE_DESCRIPTION VARCHAR(255)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Sample data
INSERT INTO ROLE (ROLE_NAME, ROLE_DESCRIPTION)
VALUES 
    ('user', 'Standard user with basic access'),
    ('admin', 'Administrator with full access');

-- Update USER table to use ROLE_ID as a foreign key (optional for now)
ALTER TABLE USER
    ADD COLUMN ROLE_ID INT,
    ADD FOREIGN KEY (ROLE_ID) REFERENCES ROLE(ROLE_ID);

-- Update existing users (assuming 'user' = ROLE_ID 1, 'admin' = ROLE_ID 2)
UPDATE USER SET ROLE_ID = 1 WHERE USER_ROLE = 'user';
UPDATE USER SET ROLE_ID = 2 WHERE USER_ROLE = 'admin';
-- Optionally drop USER_ROLE if fully migrating to ROLE_ID
-- ALTER TABLE USER DROP COLUMN USER_ROLE;