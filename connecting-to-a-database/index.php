<?php
// This file, often called the "controller," will use our Database class and include the header and footer templates to create the final webpage.

// Include the header template file.
include './templates/header.php';

// Include our custom Database class file.
include './config/database.php';

// We use a try-catch block to handle the database connection and display a message.
try {
    // Create a new instance of our Database class.
    // The constructor will automatically attempt to connect to the database.
    $database = new Database();

    // If the connection is successful, we'll get a PDO object.
    $db_connection = $database->conn;

    // Display a success message using Bootstrap's alert component.
    echo '<div class="alert alert-success" role="alert">';
    echo '🎉 Database connection successful! 🎉';
    echo '</div>';
    
    // You can add your database queries here, e.g., fetching data from a table.
    // For example: $stmt = $db_connection->prepare("SELECT * FROM users");
    // $stmt->execute();
    
} catch (Exception $e) {
    // If an error occurs, the catch block in the Database class will handle it,
    // but we can add an extra message here if needed.
    // This part of the code is not expected to run if the database class works correctly.
    // As the `die()` command in `Database.php` would have already stopped the script.
    
    // We can show a generic error message for the user.
    echo '<div class="alert alert-danger" role="alert">';
    echo 'An error occurred during the database connection.';
    echo '</div>';
}

// Include the footer template file.
include './templates/footer.php';
?>