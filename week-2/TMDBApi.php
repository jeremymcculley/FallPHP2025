<?php
/**
 * TMDBApi Class (with cURL)
 * Handles communication with the TMDB API
 */
class TMDBApi {
    private $baseUrl;
    private $apiKey;

    public function __construct($baseUrl, $apiKey) {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Make a request to TMDB API using cURL
     */
    private function request($endpoint) {
        $url = $this->baseUrl . $endpoint . "&api_key=" . $this->apiKey;

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // verify SSL

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            http_response_code(404);
            throw new Exception("cURL Error: " . curl_error($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode == 404) {
            throw new Exception("Error 404: The requested resource was not found on TMDB.");
        }

        $data = json_decode($response, true);

        // Handle TMDB error response
        if (isset($data['status_message'])) {
            throw new Exception("TMDB API Error: " . $data['status_message']);
        }

        return $data;
    }

    /**
     * Fetch popular movies with a specific page number
     */
    public function getPopularMovies($page = 1) {
        try {
            $data = $this->request("/movie/popular?language=en-US&page=" . intval($page));
            return $data['results'] ?? [];
        } catch (Exception $e) {
            echo "<p style='color:red;'><b>API Error:</b> " . $e->getMessage() . "</p>";
            return [];
        }
    }

    /**
     * Fetch a single movie by ID
     */
    public function getMovieById($movieId) {
        try {
            $data = $this->request("/movie/" . intval($movieId) . "?language=en-US");
            return $data ?? null;
        } catch (Exception $e) {
            echo "<p style='color:red;'><b>API Error:</b> " . $e->getMessage() . "</p>";
            return null;
        }
    }
}
?>