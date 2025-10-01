<?php
  // Include the database class so we can extend it here
  require_once 'database.php';
  // Define a class called 'crud' which extends our 'database' class
  // This means 'crud' will inherit all the methods and properties of the 'database' class
  class crud extends database{
    // Constructor method
    // Automatically runs when a new 'crud' object is created
    public function __construct(){
        // Call the constructor of the parent 'database' class to establish DB connection
        parent::__construct();
    }
    // Method to get (read) data from the database
    public function getData($query){
        // run the SQL query using the connection from the parent class
        $result = $this->connection->query($query);
        // if the query failed, return false
        if($result == false){
            return false;
        }
        // create an array to store all the rows in our table
        $rows = array();
        // fetch each row as an associative array and add it to $rows
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        // return the array of rows 
        return $rows;
    }
    // Method to execute (write/update/delete) a query
    public function execute($query){
        // run our query
        $result = $this->connection->query($query);
        // if the query fails display an error and stop the script
        if($result == false){
            echo "<p>Error: Could not execute the command</p>";
            return false;
        }else{
            // if the query works
            return true;
        }
    }
    // Method to escape a string before using it in a SQL query
    // Helps prevent SQL injection attacks
    public function escape_string($value){
        return $this->connection->real_escape_string($value);
    }
  }
?>
