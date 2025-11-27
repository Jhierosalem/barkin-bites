# 🐕 Barkin Bites - Dog Breeds App

A Laravel web application for dog lovers to discover and favorite dog breeds.

## 🚀 Features

- **User Authentication** - Secure login and registration system
- **Dog Breeds API** - Browse all available dog breeds from [Dog CEO API](https://dog.ceo/dog-api/)
- **Favorite System** - Like up to 3 favorite dog breeds
- **User Profiles** - View other users and their favorite dogs
- **Profile Management** - Update personal information
- **Responsive Design** - Bootstrap 5 mobile-friendly interface

## 🛠️ Tech Stack

- **Backend**: Laravel 10, PHP 8.2
- **Frontend**: Bootstrap 5, jQuery, JavaScript
- **Database**: MySQL
- **API**: Dog CEO Dog API
- **Authentication**: Laravel Sanctum

## 📋 Requirements

- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js (for frontend dependencies)

## ⚡ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Jhierosalem/barkin-bites.git
   cd barkin-bites
2. Install PHP dependencies
    bash
     composer install
3. Install frontend dependencies
    bash
    npm install

4. Environment setup
    bash
    cp .env.example .env
    php artisan key:generate

5.Configure database
    Edit .env file with your database credentials:

        env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=barkin_bites
        DB_USERNAME=your_username
        DB_PASSWORD=your_password 

6. Run migrations

    bash
    php artisan migrate

7. Start development server

    bash
    php artisan serve

8. Visit the application
    Open http://127.0.0.1:8000 in your browser

🗄️ Database Schema
users - User accounts and profiles

user_dog_likes - User's favorite dog breeds

🎯 API Endpoints
GET /dashboard - Main dashboard with dog breeds

POST /dogs/like - Like a dog breed

DELETE /dogs/unlike/{id} - Unlike a dog breed

GET /users - List all users

GET /users/{id} - Show user profile

GET /profile - Edit user profile

PUT /profile - Update user profile

👥 User Features
Register and login with secure authentication

Browse dog breeds with images from Dog CEO API

Select up to 3 favorite breeds

View other users and their favorites

Update profile information (name, email, bio, location, phone)


📱 Application Structure

        barkin-bites/
        ├── app/
        │   ├── Http/Controllers/   # Controllers
        │   ├── Models/            # Eloquent Models
        │   └── Services/          # Business Logic
        ├── resources/views/       # Blade Templates
        ├── routes/               # Application Routes
        └── database/            # Migrations and Seeders

🎨 Features Demo
Authentication
User registration and login

Password hashing and security

Session management

Dog Breeds
Fetch breeds from external API

Display breed images

Like/unlike functionality

Limit of 3 favorites per user

User Management
View all users

See other users' favorite dogs

Edit personal profile

📄 License
This project is licensed under the MIT License.

👤 Developer
Jhiero Marie Molos Salem

GitHub: @Jhierosalem

🙏 Acknowledgments
Dog CEO Dog API for providing dog breed data

Laravel community for the excellent framework

Bootstrap for the responsive UI components