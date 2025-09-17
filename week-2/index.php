<?php
/**
 * Entry point of the app
 */
require_once "config.php";
require_once "TMDBApi.php";
require_once "MovieApp.php";

// Create API handler
$api = new TMDBApi(TMDB_BASE_URL, TMDB_API_KEY);

// Create MovieApp
$app = new MovieApp($api);

// Get the current page from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;


?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="This week we will be looking at CSS Grid">
        <meta name="robots" content="noindex, nofollow">
        <title>Week 2 | APIs & Error Handling</title>
        <!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" >
        <link rel="stylesheet" href="./css/style.css">
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" ></script>
	    <link rel="preconnect" href="https://fonts.googleapis.com">
	    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    </head>
    <body>
        <main>
            <?php 
                // Show list of popular movies with pagination
                $app->showPopularMovies($currentPage);
            ?>
        </main>
    </body>
</html>