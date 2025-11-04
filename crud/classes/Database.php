<?php

// This class handles establishing a secure connection to the database using PDO.
class Database {
    // Database connection parameters
    private $host = 'localhost';
    private $db_name = 'full_crud'; // **IMPORTANT: Change this**
    private $username = 'root';  // **IMPORTANT: Change this**
    private $password = 'mysql';  // **IMPORTANT: Change this**
    public $conn;

    /**
     * Attempts to connect to the database.
     * @return PDO|null The PDO connection object or null on failure.
     */
    public function getConnection() {
        $this->conn = null;
        try {
            // Create a new PDO instance for the connection
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Set error mode to throw exceptions, which is better for debugging and handling
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Display an error message if the connection fails
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>