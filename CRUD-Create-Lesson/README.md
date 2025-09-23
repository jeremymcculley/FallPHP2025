# PHP OOP + PDO CRUD - Create

- Object-Oriented Programming (OOP)
- PDO (PHP Data Objects) for database interaction
- HTML forms with text, textarea, and checkbox inputs
- Saving form data into a MySQL database
- Bootstrap styling
- Success and error messages using Bootstrap alerts

---

## Structure

```
project/
├─ config.php          # database configuration
├─ Database.php         # PDO database connection
├─ Post.php             # Post model (saves data)
├─ index.php            # main file (form + save logic)
├─ form.php             # HTML form template
├─ templates/
│  ├─ header.php
│  └─ footer.php
└─ sql/
   └─ schema.sql       # MySQL table creation
```

---

## Instructions

### 1. Create the Database
1. Create a new database (If localhost). Example:
```sql
CREATE DATABASE myapp_db;
```

### 2. Import the Table SQL
1. Open `sql/schema.sql`.
2. Run the SQL code in your database to create the `posts` table.

### 3. Configure Database Connection
1. Open `config.php`.
2. Update the constants with your database info:
```php
define("DB_HOST", "localhost");
define("DB_NAME", "myapp_db");
define("DB_USER", "root");
define("DB_PASS", "");
```

### 4. Run the Project
1. Place the project folder inside your PHP server root (e.g., `htdocs` for Localhost).
2. Fill out the form and submit. You should see a **success alert**.

---

## Notes for Beginners
- The `is_featured` checkbox saves a boolean (1 = true, 0 = false) to the database.
- Tags are saved as a comma-separated string.
- All database errors are caught and displayed as a **red alert**.
- The project uses **Bootstrap** for styling.

---

Enjoy learning PHP OOP + PDO with forms! 🎉
