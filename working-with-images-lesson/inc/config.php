<?php
    // define our connection information
    define ('DB_HOST', 'localhost'); // change for lampstack
    define ('DB_USER', 'root'); // change for lampstack
    define ('DB_PASS', ''); // change for lampstack
    define ('DB_NAME', 'yourdatabase'); // change for lampstack
    try{
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        // set PDO error mode to exception for easier debugging
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        // if our connection fails stop the script and display the error
        die("Connection failed: " . $e->getMessage());
    }
?>