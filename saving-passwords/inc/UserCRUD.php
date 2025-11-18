<?php
// inc/UserCRUD.php

// 1. Include the Database Class
// We need access to the Database class to get the live connection object ($this->conn).
require_once 'inc/Database.php'; 

/**
 * This class handles all the Create, Read, Update, and Delete (CRUD) operations
 * specifically for the 'users' table.
 */
class UserCRUD {
    // 2. Private Properties
    private $conn; // This variable will store the active database connection (PDO object) passed from the Database class.
    private $table_name = 'users'; // The name of the database table we are working with.

    /**
     * Constructor Method
     * This runs automatically when a new UserCRUD object is created.
     * It requires a Database object to be passed in, which is how we get the connection.
     * @param Database $db The instantiated Database object.
     */
    public function __construct(Database $db) {
        // Call the connect() method from the Database object to establish the connection
        // and store the resulting PDO object in our class property ($this->conn).
        $this->conn = $db->connect();
    }

    /**
     * Creates a new user in the database.
     * This is the 'C' (Create) part of CRUD.
     *
     * @param string $username The user's chosen username.
     * @param string $email The user's email address.
     * @param string $hashed_password The password that has ALREADY been securely hashed (using password_hash()).
     * @return bool True on success, false on failure (e.g., if the username already exists).
     */
    public function create_user($username, $email, $hashed_password) {
        // 3. SQL Query
        // This is the raw SQL command to insert data into the 'users' table.
        // NOTE the use of named placeholders (e.g., :username) instead of putting the variables directly.
        $query = "INSERT INTO " . $this->table_name . "
                  SET
                    username = :username,
                    email = :email,
                    password = :password";

        // 4. Prepare the statement
        // The prepare method is crucial for **security**. It sends the SQL structure to the database first,
        // and separates the command from the data. This prevents **SQL Injection** attacks.
        $stmt = $this->conn->prepare($query);

        // 5. Bind the parameters (Securely add the data)
        // bindParam links the PHP variables ($username, $email, etc.) to the named placeholders in the query (:username, :email, etc.).
        // PDO automatically handles quoting and escaping, making the data safe.
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // We bind the securely hashed password here.

        // 6. Execute the query
        // This sends the prepared command and the bound data to the database to actually run the insert.
        if ($stmt->execute()) {
            // If the execution was successful, return true.
            return true;
        }

        // If the execution failed for any reason (e.g., a UNIQUE constraint violation), return false.
        return false;
    }
    
    // Additional CRUD functions (Read, Update, Delete) would go here.
}