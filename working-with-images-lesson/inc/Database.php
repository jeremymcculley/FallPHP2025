<?php
    // include our config file
    require_once 'config.php';
    class Database{
        // private property to hold our PDO connection object
        private $pdo;
        // public property to store any errors
        public $error = null;
        public function __construct(PDO $pdo){
            $this->pdo = $pdo;        
        }
        // Image validation and upload
        //**
        // Validates an uploaded image and moves it to the uploads folder. 
        // @param array $fileData, The $_FILES array data for the image input
        // @return string | flase returns the new image path on success or false on failure
        // */
        private function validateImage(array $fileData){
            // check to see if an image is actually uploaded
            if(empty($fileData['name'])){
                $this->error = "Please select an image";
                return false;
            }
            // Get the file properties
            $fileName = $fileData['name'];
            $fileTmpName = $fileData['tmp_name'];
            $fileSize = $fileData['size'];
            $fileError = $fileData['error'];
            // 1. check for upload errors
            if($fileError !== 0){
                $this->error = "There was an issue uploading your file";
                return false;
            }
            // 2. define the allowed types
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if(!in_array($fileExt, $allowed)){
                $this->error = "Must be jpg, jpeg, png or gif";
                return false;
            }
            // 3. set a max file size
            $maxSize = 2 * 1024 * 1024; // could just say 2MB
            if ($fileSize > $maxSize){
                $this->error = "File must be less than 2MB";
                return false;
            }
            // 4. Create a unique file name to prevent overwriting and path traversal attacks
            $newFileName = uniqid('', true) . "." . $fileExt;
            $fileDestination = 'uploads/' . $newFileName;
            // 5. move the uploaded file from the temp location to the final folder
            if(!move_uploaded_file($fileTmpName, $fileDestination)){
                $this->error = "File upload failed";
                return false;
            }
            // if all the check pass return the path to be stored in the database
            return $fileDestination;
        }
        /**
         * Create function (INSERT)
         */
        /**
         * Inserts a new product record, including the image and validation
         * @param string $name - the product name
         * @param string $description - the product description
         * @param array $fileData - the $_FILES array for the image
         * @return bool True on success, false on failure
         */
        public function create($name, $description, array $fileData){
            // first, validate and upload the image using a private method
            $imagePath = $this->validateImage($fileData);
            // if validation fails, stop and return false
            if($imagePath === false){
                return false;
            }
            try{
                // prepare the SQL INSERT statement using PDO prepared statements for security
                $sql = "INSERT INTO products (name, description, image_path) VALUES (:name, :description, :image_path)";
                // prepare our statement
                $stmt = $this->pdo->prepare($sql);
                // bind values to placeholders (this prevents SQL injection)
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image_path', $imagePath);
                // now fire the statement
                return $stmt->execute();
            }catch(PDOEXception $e){
                // Store the error message
                $this->error = "Database Error: " . $e->getMessage();
                // Clean up the uploaded image file if the database insert fails
                if(file_exists($imagePath)){
                    unlink($imagePath);
                }
                return false;
            }
        }
        /**
         * Read function
         */
        public function read(){
            try{
                // Store our SQL select statement
                $sql = "SELECT * FROM products ORDER BY id DESC";
                // execute the query
                $stmt = $this->pdo->query($sql);
                // fetch all the results in an associative array
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                $this->error = "Database read error: " . $e->getMessage();
                return false;
            }
        }
    }
    // create a global variable to hold our database object
    $db = new Database($pdo);
?>