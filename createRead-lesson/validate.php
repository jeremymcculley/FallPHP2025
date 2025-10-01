<?php
  // define a class called validate to hold all the validation functions
  class validate{
    // create a function to check if any of our required fields are empty
    public function checkEmpty($data, $fields){
        $msg = null; // initialize an empty message string
        // loop through each field name provided in $fields
        foreach($fields as $value){
            // check if that field is empty in the $data array
            if(empty($data[$value])){
                // if empty, add a message for that field
                $msg .= "<p>$value field cannot be emtpty</p>";
            }
        }
        // return our message
        return $msg;
    }
    // function to validate the age input
    public function validAge($age){
        /**
         * preg_match check if the input $age matches the regular expression pattern
         * The pattern "/^[0-9]+$/" means:
         * ^ -> this is the start of our string
         * [0-9] -> One or more digits (0 through 9)
         * $ -> This is the end of our string
         * this is pattern is a good way to check if age is a whole number
         * if I wanted to include letters then it might look like this => "/^[a-z][A-Z][0-9]+$/"
         * reference: https://www.php.net/manual/en/function.preg-match.php
         */
        if(preg_match("/^[0-9]+$/", $age)){
            return true; // this means the age is a whole number
        }
        return false;
    }
    // function to validate our email
    public function validEmail($email){
        /**
         * filter_var() is a built-in PHP function that filters/validates data.
         * In this case, we will use FILTER_VALIDATE_EMAIL
         * this checks if the input is in a valid email format.
         * This is more reliable than using preg_match to validate emails.
         * reference: https://www.php.net/manual/en/function.filter-var.php
         */
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true; // if the email follows the correct email format
        }
        return false; // if the email does not meet the correct format
    }
  }
?>
