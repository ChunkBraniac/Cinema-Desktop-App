<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h3 align="center">I'M JUST TOO GOOD!!! 😁😁</h3>

# 🎬 Movie Website Project

## Overview
The Movie Website Project is a web application designed to provide users with information about movies, including details such as title, release date, cast, plot summary, and user ratings It allows users to browse movies, search for specific titles, and view detailed information about each movie.

<img src="public/app1.png">
<img src="public/app2.png">

## Features
- **Browse Movies:** Users can browse a list of movies available in the database.
- **Search:** Users can search for movies by title or keywords.
- **Movie Details:** Users can view detailed information about each movie, including title, release date, cast, plot summary, and user ratings.
- **User Ratings:** Users can rate movies and view average ratings provided by other users.
- **User Authentication:** Secure user authentication system to manage user accounts and access control.

## 🛠️ Installation
### Prerequisites
- PHP
- Laravel
- MySQL database
- Xampp server (or any of your choice)
### Installation Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/ChunkBraniac/Cinema.git
   cd Cinema
   ```

2. Install dependencies:
   - Navigate to the project directory and run:
     ```bash
     composer install
     npm install
     ```

3. Set up the database:
   - Create a MySQL database and update the database configuration in the `.env` file.

4. Migrate the database schema:
   ```bash
   php artisan migrate
   ```

5. Seed the database with initial data (optional):
   ```bash
   php artisan db:seed
   ```

6. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

7. Access the application in your web browser at `http://127.0.0.1:8000`.

## Usage
1. **🏠 Home Page:** The home page displays a list of popular movies.
2. **🔍 Search:** Use the search bar to find specific movies by title or keywords.
3. **🎥 Movie Details:** Click on a movie title to view detailed information about the movie, including its cast, plot summary, and user ratings.
4. **🔐 User Authentication:** Register for a new account or log in with an existing account to access additional features such as rating movies.

## 🤝 Contributing
We welcome contributions from the community to improve the Movie Website Project. If you would like to contribute, please follow these steps:
1. Fork the repository and create a new branch for your feature or bug fix.
2. Make your changes and ensure the code passes all tests.
3. Submit a pull request explaining the changes you've made and why they are necessary.

## 📝 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements
- The Movie Website Project utilizes Laravel, a PHP framework, for building web applications [https://laravel.com].[https://php.net].
- Bootstrap is used for the frontend design and layout [https://getbootstrap.com/].
- JavaScript is used for client-side interactivity.

## 📧 Contact
For any inquiries or support, please contact [anthonyobah37@gmail.com](mailto:project@email.com).
