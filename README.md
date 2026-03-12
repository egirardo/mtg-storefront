# MTG Storefront

A Magic: The Gathering inventory management tool built with [Laravel](https://laravel.com/), allowing admin users to add, edit, and delete MTG products from their inventory.

---

## Table of Contents

- [About](#about)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the App](#running-the-app)
- [License](#license)

---

## About

MTG Storefront is a web-based inventory management tool for Magic: The Gathering products. It provides an admin interface for adding, editing, and deleting products from their inventory, with the ability to filter by color, price, stock, and category, as well as sort products.

---

## Tech Stack

| Layer      | Technology          |
|------------|---------------------|
| Backend    | PHP / Laravel       |
| Templating | Blade               |
| Frontend   | JavaScript / CSS / Tailwind CSS   |
| Build Tool | Vite                |
| Database   | MySQL (recommended) |

---

## Prerequisites

Make sure you have the following installed before getting started:

- **PHP** >= 8.1
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm**
- **MySQL** (or another Laravel-supported database)
- **Git**

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/egirardo/mtg-storefront.git
cd mtg-storefront
```

### 2. Navigate into the Laravel app directory

```bash
cd mtg-storefront
```

> Note: The Laravel application lives inside the nested `mtg-storefront/mtg-storefront/` directory.

### 3. Install PHP dependencies

```bash
composer install
```

### 4. Install JavaScript dependencies

```bash
npm install
```

### 5. Copy the environment file

```bash
cp .env.example .env
```

### 6. Generate the application key

```bash
php artisan key:generate
```

---

## Configuration

Open the `.env` file and update the following values to match your local environment:

```env
APP_NAME=mtg-storefront
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mtg_products
DB_USERNAME=root
DB_PASSWORD=
```

### Database Setup

First, create the database in MySQL:

```bash
mysql -u root
```

```sql
CREATE DATABASE mtg_products;
EXIT;
```

Then run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

### Storage Link

Link the public storage directory so uploaded assets are accessible:

```bash
php artisan storage:link
```

---

## Running the App

### Start the Vite dev server (frontend assets)

```bash
npm run dev
```

### Start the Laravel development server

In a separate terminal:

```bash
php artisan serve
```

The app will be available at **http://localhost:8000**.

### Build for production

```bash
npm run build
```

---

## License

This project is licensed under the [MIT License](LICENSE).
