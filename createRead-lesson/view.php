<!DOCTYPE html>
<html>
<head>
	<!-- Basic HTML setup -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD in OOP PHP | Read</title>
	<meta name="description" content="This week we will be using OOP PHP to create our CRUD application">
	<meta name="robots" content="noindex, nofollow">

	<!-- Bootstrap CSS for styling -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./css/style.css">

	<!-- Bootstrap JavaScript for interactive components -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Navbar/Header section -->
	<header>
    <nav class="navbar navbar-dark bg-primary">
      <div class="container-fluid">

        <!-- Logo that links back to the homepage -->
        <a class="navbar-brand" href="index.php">
          <img src="./img/php-logo.png" alt="header logo">
        </a>

        <!-- Responsive navbar toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible navigation links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="view.php">View</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Main content container -->
  <div class="container">
	  <div class="row">

      <!-- Start of the data table -->
		  <table class="table">
        <?php 
          // include the crud class to handle the database operations
          include_once 'crud.php';
          // create a new object of the crud class
          $crud = new crud();
          // sql query to select all the records for the database table
          $query = "SELECT * FROM createRead";
          // call the getData function to return all the results
          $results = $crud->getData($query);
        ?>
        <!-- Table headers (column names) -->
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Email</th>
          <th>Choices</th> <!-- These are the checkbox selections submitted earlier -->
        </tr>

        <!-- Loop through each row in the result set and display it -->
         <?php 
          // $result is an array of rows, each row is an associative array
          foreach($result as $key => $res){
            echo "<tr>";
              echo "<td>" . $res['name'] . "</td>"; // this displays the name from our database
              echo "<td>" . $res['age'] . "</td>"; // this displays the age from our database
              echo "<td>" . $res['email'] . "</td>"; // this displays the email from our database
              echo "<td>" . $res['checkbox'] . "</td>"; // this displays the checkbox values from our database
            echo "</tr>";
          }
         ?>
      </table>
	  </div>
  </div>
</body>
</html>
