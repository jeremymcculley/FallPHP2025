<!doctype html>
<html lang="en">
  <head>
    <!-- Basic HTML head setup -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD in OOP PHP | Add Our Data</title>
    <meta name="description" content="This week we will be using OOP PHP to create and read with our CRUD application">
    <meta name="robots" content="noindex, nofollow">

    <!-- Load Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" >

    <!-- Link to custom styles -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Load Bootstrap JavaScript functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" ></script>

    <!-- Import Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  </head>

  <body>
    <main>

    <?php
      // include our PHP class files
      include_once ('crud.php');
      include_once ('validate.php');
      // next create objects from our classes
      $crud  = new crud();
      $valid = new validate();
      // first see if our form has been submitted
      if(isset($_POST['Submit'])){
        // Sanitize user input to prevent SQL injection
        $name  = $crud->escape_string($_POST['name']);
        $age   = $crud->escape_string($_POST['age']);
        $email = $crud->escape_string($_POST['email']);
        // validate if required fields are empty
        $msg = $valid->checkEmpty($_POST, array('name', 'age', 'email'));
        // validate to see if our age is a whole number
        $checkAge = $valid->validAge($_POST['age']);
        // validate to see if our email is the correct format
        $checkEmail = $valid->validEmail($_POST['email']);
        // collect the checkbox values
        $checked_count = count($_POST['check_list']); // how many were selected
        $checkbox1 = $_POST['check_list']; // stores the selected values
        // convert the array of checkbox items into a comma-separated string
        foreach($checkbox1 as $chk1){
          $chk .= $chk1 . ", ";
        }
        // handle errors or proceed to insert a new record
        if($msg != null){
          // if there are empty fields then show the message
          echo "<p>" . $msg . "</p>";
          echo "<a href='javascript:self.history.back();'>Go Back</a>";
        }elseif(!$checkAge){
          // if the age is not valid show the message
          echo "<p>Please enter a valid age</p>";
          echo "<a href='javascript:self.history.back();'>Go Back</a>";
        }elseif(!$checkEmail){
          // if the email is not the correct format then show the message
          echo "<p>Please enter a valid email</p>";
          echo "<a href='javascript:self.history.back();'>Go Back</a>";
        }else{
          // if everything checks out then we can move our new record to the database
          $result = $crud->execute("
            INSERT INTO createRead(name, age, email, checkbox) 
            VALUES('$name', '$age', '$email', '$chk')
          ");
          // Notify user of success
          echo "<p>Data added successfully.</p>";
          echo "<a href='view.php'>View Result</a>";  // Link to view records
        }
      }
    ?>

    </main>
  </body>
</html>
