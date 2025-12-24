# Event Bulletin Board

A personal project built with Laravel 11 to deepen understanding of modern PHP development.

## Features

- User registration and authentication
- User profile management
- Event posting system with validation and ownership controls
- XML export/import for event data backup and sharing
- Real-time notifications via Pusher
- Email confirmations using Laravel's Mailable (tested with Mailtrap)
- Git branching best practices (main/dev)

## Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL
- **Real-time:** Pusher
- **Email:** Mailtrap (SMTP)

## Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+
- Node.js and npm

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## License

This is a personal learning project.
