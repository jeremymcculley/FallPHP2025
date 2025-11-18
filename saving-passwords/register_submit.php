<?php
// register_submit.php

// This file is the PHP "backend" that handles the data submitted from the registration form.

// 1. Include necessary files
// We need these files because they contain the definitions for the Database and UserCRUD classes.
require_once 'inc/Database.php'; // Contains the logic for connecting to the database.
require_once 'inc/UserCRUD.php'; // Contains the logic for creating the user record.

// Check if form was submitted
// This checks the request method used to access the page. A form submission uses 'POST'.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. Collect Data from the Form
    // The $_POST superglobal array holds all the data sent from the HTML form.
    // It's crucial to clean/validate this data in a real application, but for now, we capture it.
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 3. Check for "Confirm Password" match (Simple Validation)
    // This is a basic security and usability check done on the server-side.
    if ($password !== $confirm_password) {
        // Handle error: passwords do not match
        // 'die()' stops the script immediately and prints the error message.
        die("Error: Passwords do not match."); 
    }

    // 4. Hash the Password (Crucial Security Step)
    // NEVER save plain passwords! password_hash() is a modern, secure, and easy way to hash passwords.
    // PASSWORD_DEFAULT uses the strongest algorithm available (currently bcrypt), which is robust against attacks.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if the hashing process failed (rare, but good practice to check)
    if ($hashed_password === false) {
        // Handle error: hashing failed
        die("Error: Password hashing failed.");
    }

    // 5. Connect to DB and Instantiate CRUD Class
    // Create a new instance (object) of the Database class.
    $database = new Database();
    
    // Create a new instance of the UserCRUD class, passing the Database object into its constructor.
    // This is called Dependency Injection and gives the UserCRUD class the connection it needs.
    $crud = new UserCRUD($database);

    // 6. Save User to Database
    // Call the create_user method, passing in the clean username, email, and the SECURELY HASHED password.
    if ($crud->create_user($username, $email, $hashed_password)) {
        // If create_user returns TRUE, registration was successful.
        echo '<p class="alert alert-success">User registered successfully!</p>';
        // A real app would redirect the user here: header('Location: login.php');
    } else {
        // If create_user returns FALSE (e.g., PDO failed, or a database constraint like UNIQUE was violated).
        echo '<p class="alert alert-danger">Error: Could not register user. Username or email might be taken.</p>';
    }
} else {
    // If the page was accessed directly (not via a form submission), redirect the user back to the form.
    // This prevents direct access to the processing file.
    header('Location: register.php');
}