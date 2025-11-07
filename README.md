Laravel Backend API Project

This is a Laravel 11 application, serving as a dedicated backend API. It manages core application data, including invoices and customer information, connecting to a MySQL database.

# Installation Guide

To get the API running on your local machine, follow these steps.

**Prerequisites**

Ensure you have the following installed on your system:

PHP (>= 8.2 recommended): Laravel 11 requires PHP 8.2 or higher.

Composer: For managing PHP dependencies.

MySQL: Your database server.

**Installation Instructions**

Clone the Repository

git clone [your-repository-url]
cd [project-name]


**Install PHP Dependencies**

Use Composer to download all the necessary PHP packages:

composer install


**Set Up Environment File**

Copy the example environment file and create your local configuration:

cp .env.example .env


**Configure .env**

Open the newly created .env file and update the following sections. Note that the default template might show SQLite settings; be sure to change these to your MySQL credentials:

Set the application name and URL:

APP_NAME="Laravel API"
APP_URL=http://localhost:8000


**Configure MySQL database connection:**

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password


**Generate Application Key**

This command sets the necessary encryption key for your application:

php artisan key:generate


**Run Database Migrations and Seeding**

Set up the database tables and populate them with initial data (including the invoices table):

php artisan migrate --seed


**Start the Local Server**

Launch the Laravel development server:

php artisan serve


The API should now be running at http://127.0.0.1:8000.

**Usage and Testing**

Accessing the API

All API routes are prefixed with /api (routes are defined in routes/api.php). For example, if you have a route defined as /invoices, the full URL is:

http://127.0.0.1:8000/api/invoices

Use a tool like Postman or Insomnia to send GET, POST, PUT, and DELETE requests to your endpoints.

## Postman requests outcome
<img width="898" height="678" alt="postman request specific ID" src="https://github.com/user-attachments/assets/73f06905-17c2-4f0d-a83b-5b1fb0834615" />
<img width="899" height="732" alt="postman request" src="https://github.com/user-attachments/assets/84915970-bf03-4522-b605-d42be5ef807a" />
<img width="895" height="479" alt="post-request Postman" src="https://github.com/user-attachments/assets/58ec5297-aa7e-4d71-8107-3f0a23bf5b9d" />
<img width="877" height="679" alt="post invoices" src="https://github.com/user-attachments/assets/9bb31094-c71e-4566-9268-c5edf2717508" />


