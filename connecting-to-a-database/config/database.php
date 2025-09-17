<?php
// Build a dedicated class to handle the database connection. This centralizes our logic and makes it easy to reuse.

// Define a class named 'Database'
class Database {
    // Private properties to hold our connection details.
    private $host = "172.31.22.43"; // The database server hostname.
    private $db_name = "YourDBname"; // Your database name.
    private $username = "YourUsername"; // Your database username.
    private $password = "YourPassword"; // Your database password.
    public $conn; // A public property to store the PDO connection object.

    // This is the constructor method, which is automatically called when a new object is created.
    public function __construct() {
        // Initialize the connection property to null.
        $this->conn = null;
        
        // Use a try-catch block for error handling.
        try {
            // Create a new PDO instance to connect to the database.
            // The DSN (Data Source Name) specifies the database type (mysql), host, and database name.
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Set PDO error mode to throw exceptions, which makes it easy to catch errors.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            // If the connection fails, catch the exception.
            // We use `die()` to stop the script and display an error message.
            die("Connection error: " . $exception->getMessage());
        }
    }
}
?>