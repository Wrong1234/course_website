# Laravel Course Creation System
 A comprehensive web application built with Laravel that allows users to create courses with multiple modules and content items. This project features a dynamic frontend interface with   nested course structure management and robust backend data handling.

## Features
 - Course Management: Create courses with essential details (title, description, category)
- Dynamic Module Creation: Add unlimited modules to each course
- Nested Content Structure: Add multiple content items within each module
- Real-time Validation: Both frontend and backend validation
- Responsive Design: User-friendly interface built with HTML, CSS, and JavaScript
- Database Integration: Proper relational database structure
- Error Handling: Comprehensive error handling with user-friendly feedback

## Requirements
 - PHP >= 8.1
 - Composer
 - Node.js & NPM
 - MySQL/PostgreSQL/SQLite
 - Laravel 10.x
   
# Installation & Setup

1. Clone the Repository
bash
git clone https://github.com/your-username/laravel-course-creation.git
cd laravel-course-creation
2. Install Dependencies
bash
## Install PHP dependencies
composer install

## Install JavaScript dependencies
npm install
3. Environment Configuration
bash
## Copy environment file
cp .env.example .env

## Generate application key
 - php artisan key:generate
4. Database Setup
 - Configure your database settings in .env file:

## env
 - DB_CONNECTION=mysql
 - DB_HOST=127.0.0.1
 - DB_PORT=3306
 - DB_DATABASE=course_creation
 - DB_USERNAME=your_username
 - DB_PASSWORD=your_password
## 5. Run Migrations
 - php artisan migrate
## 6. Build Assets
 - npm run dev
# or for production
 - npm run build
7. Start the Application
 - php artisan serve
 - Visit http://localhost:8000 to access the application.

# Project Structure
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   └── CourseController.php
    │   │   └── Requests/
    │   │       └── CourseRequest.php
    │   └── Models/
    │       ├── Course.php
    │       ├── Module.php
    │       └── Content.php
    ├── database/
    │   └── migrations/
    │       ├── create_courses_table.php
    │       ├── create_modules_table.php
    │       └── create_contents_table.php
    ├── resources/
    │   ├── views/
    │   │   └── courses/
    │   │       └── create.blade.php
    │   └── js/
    │       └── course-creation.js
    └── routes/
        └── web.php
        
# Database Schema

 ## Courses Table
  - id - Primary key
  - title - Course title
  - description - Course description
  - category - Course category
  - created_at - Timestamp
  - updated_at - Timestamp
    
## Modules Table
  - id - Primary key
  - course_id - Foreign key to courses
  - title - Module title
  - order - Module order
  - created_at - Timestamp
  - updated_at - Timestamp
    
## Contents Table
  - id - Primary key
  - module_id - Foreign key to modules
  - title - Content title
  - type - Content type (text, image, video, link)
  - content - Content data
  - order - Content order
  - created_at - Timestamp
  - updated_at - Timestamp
    
# Key Features Implementation

## Frontend Features
 - Dynamic Form Management: Add/remove modules and content dynamically
- Nested Structure Visualization: Clear hierarchy display
- Client-side Validation: Real-time form validation
- Responsive Design: Mobile-friendly interface
- Interactive UI: Smooth user experience with jQuery
  
##Backend Features
 - RESTful API: Clean API endpoints for course management
 - Form Request Validation: Comprehensive server-side validation
 - Database Relationships: Proper Eloquent relationships
 - Error Handling: Graceful error handling and user feedback
 - Design Patterns: Repository pattern implementation
   
## API Endpoints
 - GET    /courses          - List all courses
 - GET    /courses/create   - Show course creation form
 - POST   /courses          - Store new course
 - GET    /courses/{id}     - Show specific course
 - PUT    /courses/{id}     - Update course
 - DELETE /courses/{id}     - Delete course
 - 
# Validation Rules

## Course Validation
 - Title: Required, string, max 255 characters
 - Description: Required, string
 - Category: Required, string
 - 
## Module Validation
 - Title: Required, string, max 255 characters
 - Order: Integer, minimum 1
   
## Content Validation
 - Title: Required, string, max 255 characters
 - Type: Required, in ['text', 'image', 'video', 'link']
 - Content: Required based on type
 - Order: Integer, minimum 1
   
## Frontend Technologies
 - HTML5: Semantic markup
 - CSS3: Modern styling with Flexbox/Grid
 - Vanilla JavaScript: Core functionality
 - jQuery: DOM manipulation and AJAX

## Security Features
 - CSRF Protection
 - Input Sanitization
 - SQL Injection Prevention
 - XSS Protection
 - Form Validation
## Testing
 - Run the test suite:


# php artisan test

## Course Creation Form
 ![image alt](/public/images/create.png)

## Course Index page
 ![image alt](/public/images/index.png)

## Full Course View
 ![image alt](/public/images/view1.png)
![image alt](/public/images/view2.png)
![image alt](/public/images/view3.png)
![image alt](/public/images/view4.png)

# Deployment
## Production Setup
 - Set APP_ENV=production in .env
 - Run php artisan config:cache
 - Run php artisan route:cache
 - Run php artisan view:cache
 - Set proper file permissions
 - Configure web server (Apache/Nginx)



