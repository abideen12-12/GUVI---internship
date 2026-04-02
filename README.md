GUVI Internship - User Authentication & Profile System
About the Project
This is a simple full stack project where users can register, log in, and manage their profile. The idea was to build something close to how real applications work by using different databases for different purposes.
The flow is:
Register → Login → Profile

What I Used
HTML, CSS (Bootstrap) for UI
JavaScript + jQuery (AJAX)
PHP for backend
MySQL for storing user login data
MongoDB for storing profile details
Redis for handling sessions

Features
Users can register with email and password
Passwords are stored securely (hashed)
Login validates user using MySQL
After login, a session is created using Redis
Profile details are stored in MongoDB
Profile fields are read-only by default
Click "Edit" to update details
Data is saved and shown again after next login




How to Run
Put the project inside:
C:\xampp\htdocs\Project

Start:
Apache
MySQL
MongoDB (mongod)
Redis (redis-server)
Install dependencies:
composer install

Create database in phpMyAdmin:
CREATE DATABASE user_auth;

USE user_auth;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255)
);

Open in browser:
http://localhost/Project/index.html


How It Works (Simple)
Register → user saved in MySQL
Login → credentials checked + session stored in Redis
Profile → data fetched from MongoDB
Edit → enables fields → save updates

Notes
Used prepared statements for MySQL
Used AJAX instead of form submission
Did not use PHP sessions (used Redis instead)

By Abideen P S

