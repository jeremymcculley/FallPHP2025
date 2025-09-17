# PHP TMDB API Integration (Beginner Friendly)

This project demonstrates **Object-Oriented PHP**, **API integration**, and **error handling** using the [TMDB API](https://developer.themoviedb.org/).  
It has been simplified for beginners — no database connection is required.

---

## 🚀 Setup Instructions

1. **Get a TMDB API Key**
   - Create a free account at [TMDB](https://developer.themoviedb.org/).
   - Go to your account settings and generate an API key.
   - Copy the key.

2. **Configure Your API Key**
   - Open `config.php`
   - Replace:
     ```php
     define("TMDB_API_KEY", "YOUR_TMDB_API_KEY_HERE");
     ```
     with your real TMDB API key.

3. **Run the Project**
   - Place the project folder in your local web server root (`htdocs` for XAMPP, `www` for WAMP, etc.).
   - Start Apache (or your web server).
   - Visit in your browser:
     ```
     http://localhost/phpApiIntegration/index.php
     ```

---

## 📂 File Structure

- `config.php` → stores API key and base URL  
- `TMDBApi.php` → class that handles TMDB API requests (uses cURL)  
- `MovieApp.php` → main application logic (shows movies)  
- `index.php` → entry point (runs the app and displays results)  

---

## 🛠 Troubleshooting

### Error: "Could not reach TMDB API"
- Check that your internet is working.
- Verify your API key in `config.php` is correct.
- Make sure `cURL` is enabled in your PHP installation (`phpinfo()` should list it).

### Error: "TMDB API Error: Invalid API key"
- You have not replaced the placeholder key in `config.php` with your real API key.

### Error 404
- The requested resource was not found. This happens if you try to fetch a movie by an invalid ID.

---

## ✅ Example Usage

- View **popular movies** (default on `index.php`)
- Fetch a **single movie** by editing `index.php` and uncommenting:
  ```php
  $app->showMovieDetails(550); // Fight Club
  ```

---

## 📚 Learning Points

- How to structure PHP code with classes (`OOP`).
- How to fetch data from an external API (`TMDB`).
- How to handle errors (network, API, 404s).
- How to output results safely in HTML (`htmlspecialchars`).

---

Enjoy coding 🎬
