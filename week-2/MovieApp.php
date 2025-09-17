<?php
/**
 * MovieApp Class
 * Controls the main logic of our app
 */
class MovieApp {
    private $api;

    public function __construct(TMDBApi $api) {
        $this->api = $api;
    }

    /**
     * Display a list of popular movies with pagination
     */
    public function showPopularMovies($page = 1) {
        $movies = $this->api->getPopularMovies($page);

        if (empty($movies)) {
            echo "<p>No movies found. Please try again later.</p>";
            return;
        }
        ?>
        <section class='row'>
            <?php echo "<h2>Popular Movies (Page {$page})</h2>"; ?>
        </section>
        <section class="row">
        <?php
        foreach ($movies as $movie) {
            $title = htmlspecialchars($movie['title'] ?? "Unknown Title");
            $releaseDate = htmlspecialchars($movie['release_date'] ?? "N/A");
            $posterPath = $movie['poster_path'] ?? null;
            $imageUrl = $posterPath ? "https://image.tmdb.org/t/p/w500" . htmlspecialchars($posterPath) : "https://via.placeholder.com/100x150.png?text=No+Image";
        ?>
            <div class="sm-col-4 md-col-3 col-lg-3">
                <?php echo "<img class='movie-img' src='{$imageUrl}' alt='{$title} Poster'>"; ?>
                <?php echo "<h3>{$title}</h3>"; ?>
                <?php echo "<p>({$releaseDate})</p>"; ?>
            </div>
        <?php
        }
        ?>
        </section>
        <?php
        // Pagination Links
        echo "<div>";
        $prevPage = max(1, $page - 1);
        $nextPage = $page + 1;
        
        if ($page > 1) {
            echo "<a href='?page={$prevPage}'>&laquo; Previous Page</a> &nbsp;";
        }
        echo "<a href='?page={$nextPage}'>Next Page &raquo;</a>";
        echo "</div>";
    }

    /**
     * Display a single movie by ID
     */
    // public function showMovieDetails($movieId) {
    //     $movie = $this->api->getMovieById($movieId);

    //     if (!$movie) {
    //         echo "<p>Movie not found (ID: {$movieId}).</p>";
    //         return;
    //     }

    //     echo "<h2>" . htmlspecialchars($movie['title']) . "</h2>";
    //     echo "<p><b>Release Date:</b> " . htmlspecialchars($movie['release_date']) . "</p>";
    //     echo "<p><b>Overview:</b> " . htmlspecialchars($movie['overview']) . "</p>";
    // }
}
?>