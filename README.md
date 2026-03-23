# Supermarket POS System

A comprehensive Point of Sale (POS) system designed for supermarkets, built with Laravel 12. This application streamlines checkout processes, inventory management, employee tracking, and sales reporting.

## Features

- **Point of Sale (POS)**: Efficient and intuitive checkout experience.
- **Product Management**: Add, edit, and restock products.
- **Inventory Tracking**: Real-time stock levels and restock management.
- **Employee Management**: Manage staff roles and access levels.
- **Sales & Reporting**: View detailed sales reports and generate receipts.
- **Barcode Generation**: Built-in barcode generation for products (using `picqer/php-barcode-generator`).

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com) (PHP ^8.2)
- **Frontend**: Blade Templates, Tailwind CSS (v4), Vite
- **Database**: SQLite / MySQL (configurable)

## Requirements

- PHP ^8.2
- Composer
- Node.js & NPM

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/sounvisal/Supermarket-pos-system.git
   cd Supermarket-pos-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the `.env.example` to `.env` and configure your database settings.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Run Development Server**
   Start both the Laravel server and Vite asset compilation simultaneously:
   ```bash
   composer run dev
   ```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
