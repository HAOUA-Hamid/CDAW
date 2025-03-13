# User Management REST API

This project provides a simple REST API for user management with CRUD operations using PHP and MySQL.

## API Base URL
```
http://localhost:8080/CDAW/BackEnd/tp2/api.php/users
```

## Endpoints

### 1. **Get All Users**
- **Request:** `GET /users`
- **Response:**
```json
[
    {"id": 1, "name": "John Doe", "email": "john@example.com"},
    {"id": 2, "name": "Jane Doe", "email": "jane@example.com"}
]
```

### 2. **Get a Single User**
- **Request:** `GET /users/{id}`
- **Response:**
```json
{"id": 1, "name": "John Doe", "email": "john@example.com"}
```

### 3. **Create a User**
- **Request:** `POST /users`
- **Body:**
```json
{
    "name": "Alice",
    "email": "alice@example.com"
}
```
- **Response:**
```json
{"id": 3}
```

### 4. **Update a User**
- **Request:** `PUT /users/{id}`
- **Body:**
```json
{
    "name": "Alice Updated",
    "email": "alice.new@example.com"
}
```
- **Response:**
```json
{"message": "User updated"}
```

### 5. **Delete a User**
- **Request:** `DELETE /users/{id}`
- **Response:**
```json
{"message": "User deleted"}
```

## Setup & Usage
1. **Start WAMP/XAMPP** and ensure MySQL is running.
2. Place the project inside the `www` directory (`CDAW/BackEnd/tp2`).
3. Import the `dbtest` database schema.
4. Access the API via:
   ```
   http://localhost:8080/CDAW/BackEnd/tp2/api.php/users
   ```
5. Use the provided `index.html` file to interact with the API.

## Tools Used
- PHP (API Backend)
- MySQL (Database)
- JavaScript & HTML (Frontend)

## Author
Created by Hamid HAOUA