<?php 
    class Database{
        // These private properties store the database information
        // These have been defined in the config.php
        private $host = DB_HOST;
        private $db   = DB_NAME;
        private $user = DB_USER;
        private $pass = DB_PASS;
        // This property will hold the PDO object
        private $pdo;
        // Create our method to return tge database connection
        public function getConnection(){
            // Check the DSN (Data source name) string with host, and charset
            if($this->pdo === null){
                try{
                    $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
                    // create a new PDO object using the DSN, username and the password
                    $this->pdo = new PDO($dsn, $this->user, $this->pass);
                    // Set the PDO to throw exceptions when an error occurs
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    // If something goes wrong stop the script and show the error message
                    die("Could not connect to the database: " . $e->getMessage());
                }
            }
            return $this->pdo;
        }  
    }
?>