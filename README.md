# SEU Event Management System

## Project Overview

The SEU Event Management System is a web-based application designed to help university students discover events and register for them online. Administrators can manage events through a separate dashboard.

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- MySQL
- XAMPP
- phpMyAdmin

## Main Features

- User registration and login
- Role-based access for students and administrators
- Event listing and search
- Event creation, editing, and deletion by administrators
- Student event registration
- Personal registration history
- Password hashing and session-based authentication

## Installation

1. Install XAMPP and start Apache and MySQL.
2. Copy the project folder into `htdocs`.
3. Open phpMyAdmin and create a database named `seu_event_system`.
4. Import `database/seu_event_system.sql`.
5. Configure `config/database.php` for your local database.
6. Open `http://localhost/seu-event-system/` in your browser.

## Database

The project uses MySQL tables for users, events, and registrations.

## Project Status

The application has been developed and tested locally. Public deployment requires a hosting service that supports PHP and MySQL.
