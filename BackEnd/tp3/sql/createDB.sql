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