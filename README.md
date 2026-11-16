# Istapa

Istapa is a Laravel-based school management and education platform designed to help institutions manage academic operations, student information, admissions, attendance, and communication in one place.

## Project Overview

This project combines a public-facing school website with a secure administration dashboard. It is built to support the day-to-day operations of an educational institution, including student enrollment, class management, academic tracking, and financial administration.

## Key Features

- Student admissions and inquiry management
- Course and program listings with details and lesson content
- Blog, events, gallery, and contact management
- Academic year and class management
- Subject and exam management
- Attendance tracking and reporting
- Fees and payment tracking
- Student marks and academic performance records
- Role-based access for admin and manager users
- Dashboard analytics for school activity and statistics

## Technology Stack

- PHP 8.1
- Laravel 10
- MySQL database
- Vite for frontend assets
- Bootstrap-based UI templates
- Artisan-based admin workflows

## Project Structure

- app/ - application logic, controllers, models, and service code
- routes/ - web routes for public pages and admin features
- resources/ - views, CSS, and frontend assets
- database/ - migrations, seeders, and schema definitions
- public/ - public web assets
- tests/ - automated tests

## Getting Started

### Prerequisites

- PHP 8.1 or later
- Composer
- Node.js and npm
- MySQL database

### Installation

1. Clone the repository
   ```bash
   git clone <repository-url>
   cd istapa
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install frontend dependencies
   ```bash
   npm install
   ```

4. Create your environment file
   ```bash
   cp .env.example .env
   ```

5. Configure your database settings in the `.env` file.

6. Generate the application key
   ```bash
   php artisan key:generate
   ```

7. Run database migrations
   ```bash
   php artisan migrate
   ```

8. Compile frontend assets
   ```bash
   npm run build
   ```

9. Start the application
   ```bash
   php artisan serve
   ```

Then open your browser at `http://localhost:8000`.

## Notes

This application is tailored for a school administration environment and is intended to streamline academic and operational processes while maintaining a readable public website for prospective students and families.

## License

This project is open-source and uses the MIT license.
