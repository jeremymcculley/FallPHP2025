<?php
// inc/Database.php

/**
 * This class is responsible for connecting to the MySQL database.
 * It follows the Object-Oriented Programming (OOP) principle,
 * keeping the database logic separate and reusable.
 */
class Database {
    // 1. Private Properties (Variables) for Connection Details
    // The 'private' keyword means these variables can ONLY be accessed from within this class.
    private $host = 'localhost'; // The server where your database is running (usually 'localhost' on a dev machine)
    private $db_name = 'user_crud_db'; // The name of the database we want to connect to
    private $username = 'root'; // The username for your database (often 'root' by default)
    private $password = 'mysql'; // **IMPORTANT**: Your database password. Change this!
    private $conn; // This variable will hold the actual database connection object (PDO instance)

    /**
     * Get the database connection
     *
     * @return PDO|null Returns the PDO connection object if successful, or null if it fails.
     */
    public function connect() {
        // Start by ensuring the connection variable is empty/null
        $this->conn = null;

        // The 'try...catch' block is essential for error handling.
        // We 'try' to connect, and if it fails, the 'catch' block runs instead.
        try {
            // 2. Create a new PDO instance (the actual connection)
            // PDO (PHP Data Objects) is a modern, secure way to talk to databases.
            $this->conn = new PDO(
                // The DSN (Data Source Name) string tells PDO what kind of DB it is and where to find it.
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            
            // 3. Configure Error Handling
            // This line ensures that if a database query fails, PHP throws a real exception (an error).
            // This makes debugging much easier and is a best practice for PDO.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 4. Catch Connection Failures
        // If the connection fails (e.g., wrong password, DB not running), PDO will throw a PDOException.
        } catch (PDOException $exception) {
            // We catch the error and display a simple message.
            // In a live application, you would log this error instead of echoing it publicly.
            echo 'Connection Error: ' . $exception->getMessage();
        }

        // 5. Return the Connection
        // Return the connection object. Other classes (like the UserCRUD class) will use this object
        // to send SQL queries to the database.
        return $this->conn;
    }
}