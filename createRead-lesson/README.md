# 📘 CRUD in OOP PHP — Beginner Project  

This project demonstrates how to build a **CRUD (Create, Read, Update, Delete)** application using **Object-Oriented PHP**, **MySQLi**, and **Bootstrap** for styling.  
It is designed for **beginners** learning PHP, MySQL, and OOP principles.  

---

## 🧱 Project Structure  
```
project-folder/
│
├── index.php              → The form to add data (Create)
├── view.php               → Displays data from database (Read)
│
├── crud.php               → Class to handle database queries (CRUD logic)
├── validate.php           → Class to validate form input
├── database.php           → Class to connect to MySQL database
│
├── css/
│   └── style.css          → Optional custom styles
│
├── img/
│   └── php-logo.png       → Logo used in navbar
│
└── README.md              → This file
```

---

## 🔧 Requirements
- PHP 7.x or newer  
- MySQL or MariaDB  
- A web server (Apache via **XAMPP**, **MAMP**, or **WAMP**)  
- Database: `createread` with table `createRead`  

---

## 📄 Database Setup
Run the following SQL to create the database and table:  

```sql
CREATE DATABASE createread;

USE createread;

CREATE TABLE createRead (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  age INT,
  email VARCHAR(255),
  checkbox TEXT
);
```

---

## 📁 File Breakdown  

### `index.php` – Create New Record  
- Displays a form for the user to input:  
  - Name  
  - Age  
  - Email  
  - Checkbox selections (choices)  
- Includes validation:  
  - Empty field check  
  - Valid email format (`filter_var`)  
  - Valid age (digits only via `preg_match`)  
- On success, inserts data into the database and shows a confirmation.  

---

### `view.php` – Read/Display Records  
- Connects to the database and fetches all records from `createRead`.  
- Displays data in an HTML table with Bootstrap styling.  
- Uses the `crud` class to query data.  

---

### `crud.php` – CRUD Class  
Handles database interactions:  

**Key Methods**  
- `__construct()` → Inherits DB connection from `database.php`  
- `getData($query)` → Executes `SELECT` queries and returns results as arrays  
- `execute($query)` → Executes any SQL query (`INSERT`, `DELETE`, etc.)  
- `escape_string($value)` → Escapes special characters (prevents SQL injection)  

---

### `validate.php` – Validation Class  
Handles form input validation:  

**Key Methods**  
- `checkEmpty($data, $fields)` → Checks if fields are empty  
- `validAge($age)` → Ensures age contains only digits (`preg_match`)  
- `validEmail($email)` → Validates format using `filter_var`  

---

### `database.php` – Database Connection Class  
- Connects to MySQL database using **MySQLi OOP**.  
- Stores DB credentials (host, username, password, database).  
- Constructor establishes connection and stops execution on failure.  
- `$connection` property is **protected** → child classes (like `crud`) can access it.  

---

## 🧠 What You’ll Learn
- How to build CRUD operations in PHP using **OOP**  
- How to connect to a database with **MySQLi**  
- How to validate and sanitize user input  
- How to organize PHP into **reusable classes**  
- How to output **dynamic HTML** from PHP  
- How to style with **Bootstrap**  

---

## 🚀 Future Improvements  
- ✅ Add **Update** and **Delete** functionality to complete CRUD  
- 🔐 Switch from **MySQLi** to **PDO** with prepared statements  
- 🧪 Add **error handling** and client-side validation  
- 📱 Improve UI with **JavaScript enhancements**  
- 📦 Add **pagination** for large datasets  
