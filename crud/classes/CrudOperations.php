<?php
require_once 'Database.php';

// This class contains all the business logic for interacting with the database.
class CrudOperations {
    private $conn;
    private $table_name = "form_data"; // Your database table name

    // Constructor: receives the database connection object
    public function __construct($db) {
        $this->conn = $db;
    }

    // --- Server-Side Validation (Essential for security) ---
    public function validateData($data) {
        $errors = [];

        // 1. Name Validation
        if (empty($data['name'])) {
            $errors['name'] = "Name is required.";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $data['name'])) {
            $errors['name'] = "Only letters and white space allowed for Name.";
        }

        // 2. Email Validation
        if (empty($data['email'])) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }

        // 3. Radio Input Validation
        $valid_options = ['option_a', 'option_b'];
        if (empty($data['radio_option']) || !in_array($data['radio_option'], $valid_options)) {
            $errors['radio_option'] = "A valid radio option must be selected.";
        }

        // 4. Message Validation
        if (empty($data['message'])) {
            $errors['message'] = "Message cannot be empty.";
        }

        // You can add more specific validation for 'text_input' if needed

        return $errors;
    }

    // --- CREATE Operation ---
    public function create($data) {
        $validation_errors = $this->validateData($data);
        if (!empty($validation_errors)) {
            return ['success' => false, 'errors' => $validation_errors];
        }

        // Use prepared statements for security against SQL injection
        $query = "INSERT INTO " . $this->table_name . "
                  SET name=:name, email=:email, radio_option=:radio_option, 
                  checkbox_option=:checkbox_option, message=:message, text_input=:text_input";

        $stmt = $this->conn->prepare($query);

        // Sanitize and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $radio_option = htmlspecialchars(strip_tags($data['radio_option']));
        $message = htmlspecialchars(strip_tags($data['message']));
        $text_input = htmlspecialchars(strip_tags($data['text_input']));
        // Convert checkbox state to a simple string for the DB
        $checkbox_option = isset($data['checkbox_option']) ? 'Yes' : 'No';

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':radio_option', $radio_option);
        $stmt->bindParam(':checkbox_option', $checkbox_option);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':text_input', $text_input);

        if($stmt->execute()){
            return ['success' => true, 'message' => 'Record created successfully.'];
        }
        return ['success' => false, 'message' => 'Failed to create record.'];
    }

    // --- READ Operation (Read All Records) ---
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // Returns the PDOStatement object, which can be looped through in index.php
        return $stmt; 
    }
    
    // --- READ Operation (Read Single Record by ID - used for the Update form) ---
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        // Bind the ID parameter
        $stmt->bindParam(1, $id);
        $stmt->execute();
        // Fetch the single row as an associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        return $row;
    }

    // --- UPDATE Operation ---
    public function update($id, $data) {
        $validation_errors = $this->validateData($data);
        if (!empty($validation_errors)) {
            return ['success' => false, 'errors' => $validation_errors];
        }

        $query = "UPDATE " . $this->table_name . "
                  SET name=:name, email=:email, radio_option=:radio_option, 
                  checkbox_option=:checkbox_option, message=:message, text_input=:text_input
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $radio_option = htmlspecialchars(strip_tags($data['radio_option']));
        $message = htmlspecialchars(strip_tags($data['message']));
        $text_input = htmlspecialchars(strip_tags($data['text_input']));
        $checkbox_option = isset($data['checkbox_option']) ? 'Yes' : 'No';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':radio_option', $radio_option);
        $stmt->bindParam(':checkbox_option', $checkbox_option);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':text_input', $text_input);
        
        if($stmt->execute()){
            // Check if any row was actually affected (not always necessary, but good for feedback)
            if ($stmt->rowCount() > 0) {
                 return ['success' => true, 'message' => 'Record updated successfully.'];
            }
            return ['success' => true, 'message' => 'Record updated successfully (No changes made).'];
        }
        return ['success' => false, 'message' => 'Failed to update record.'];
    }

    // --- DELETE Operation ---
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        // Sanitize the ID and bind it
        $clean_id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $clean_id);

        if($stmt->execute()){
            // Check if a row was actually deleted
            if ($stmt->rowCount() > 0) {
                 return ['success' => true, 'message' => 'Record deleted successfully.'];
            }
            return ['success' => false, 'message' => 'Record not found or already deleted.'];
        }
        return ['success' => false, 'message' => 'Failed to delete record.'];
    }
}
?>