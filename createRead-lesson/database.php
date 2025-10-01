<?php
  // define our class called Database
  class Database{
    // database information
    private $host     = 'localhost'; // Host name (usually 'localhost' for local servers)
    private $username = 'root'; // MySQL username
    private $password = ''; // MySQL password (empty if using XAMPP default)
    private $database = 'createread'; // The name of your database
    // the database connection variable, this will hold the actual connection object
    protected $connection;

    // --- Constructor ---
    // This function is called automatically when a new object of this class is created
    public function __construct(){
        // Check if the connection has NOT been set already
        if(!isset($this->connection)){
            // Try to create a new MySQLi connection using the credentials provided above
            $this->connection = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );
            // check to see if the connection failed
            if(!$this->connection){
                // show an error message and stop the script
                echo "<p>Cannot connect to database</p>";
                exit;
            }
        }
        // Return the connection (not strictly necessary in PHP constructors)
        return $this->connection;
    }
  }
?>
