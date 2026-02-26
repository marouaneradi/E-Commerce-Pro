# E-Commerce Pro

## Description

A full-stack, production-ready e-commerce platform built with **Laravel 10+** and **Pure CSS**. Features a complete storefront with product catalog, shopping cart, checkout, user dashboard, and admin panel. Designed for portfolio-level quality with modern UI, dark mode, and responsive design.

## Features

- ✅ **Authentication** — Register, Login, Logout, Email Verification, Password Reset
- 🛍️ **Public Store** — Homepage, Product Listing, Product Detail, Search, Category Filter, Price Sort
- 📦 **Products System** — CRUD, Categories, Image Upload, Stock Management, Ratings
- 🛒 **Shopping Cart** — Session-based, Add/Remove/Update, Subtotal & Total
- 💳 **Checkout** — Order Creation, Stock Deduction, Order Confirmation
- 📊 **User Dashboard** — Order History, Order Details, Account Settings
- ⚙️ **Admin Panel** — Dashboard Stats, Product CRUD, Category CRUD, Order Management, User Management
- 🌙 **Dark Mode** — Full dark mode toggle with persistence
- 📱 **Responsive** — Mobile-friendly design

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 10+ (PHP 8.1+) |
| Database | MySQL |
| Auth | Laravel Breeze (custom Blade) |
| Frontend | Blade Templates + Vite |
| CSS | Pure CSS (no frameworks) |
| JavaScript | Vanilla JS |
| Image Storage | Laravel Storage (local/S3) |

## Demo Accounts

After seeding, use these accounts:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| User | user1@example.com | password |

## Installation Steps

### Requirements
- PHP 8.1+
- Composer
- Node.js 16+ & npm
- MySQL 5.7+ or MariaDB

### Setup

**1. Clone the repository**
```bash
git clone https://github.com/yourusername/ecommerce-pro.git
cd ecommerce-pro
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install Node dependencies**
```bash
npm install
```

**4. Copy environment file**
```bash
cp .env.example .env
```

**5. Configure MySQL in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_pro
DB_USERNAME=root
DB_PASSWORD=
```

**6. Generate application key**
```bash
php artisan key:generate
```

**7. Run migrations and seed demo data**
```bash
php artisan migrate --seed
```

**8. Create storage symlink**
```bash
php artisan storage:link
```

**9. Start Vite development server**
```bash
npm run dev
```

**10. Start Laravel development server**
```bash
php artisan serve
```

Open: **http://127.0.0.1:8000**

## Production Build

```bash
npm run build
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Project Structure

```
ecommerce-pro/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Auth controllers
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   └── UserDashboardController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── ProductReview.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Services/
│       └── CartService.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   ├── app.css             # Main styles
│   │   └── admin.css           # Admin styles
│   ├── js/
│   │   └── app.js              # Main JS
│   └── views/
│       ├── layouts/
│       ├── admin/
│       ├── auth/
│       ├── cart/
│       ├── checkout/
│       ├── partials/
│       ├── products/
│       ├── user/
│       └── home.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
└── vite.config.js
```

## Deployment on Render (Docker + MySQL)

### Prerequisites
- Render account
- Docker Hub account (or GitHub Container Registry)

### Step 1: Create Dockerfile

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
```

### Step 2: Deploy on Render

1. Push code to GitHub
2. Go to [render.com](https://render.com) → **New Web Service**
3. Connect your GitHub repo
4. Set **Environment**: Docker
5. Add **Environment Variables**:
   ```
   APP_KEY=<generate with php artisan key:generate --show>
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=mysql
   DB_HOST=<your-render-mysql-host>
   DB_PORT=3306
   DB_DATABASE=ecommerce_pro
   DB_USERNAME=<username>
   DB_PASSWORD=<password>
   ```
6. Create a **MySQL database** on Render (or use PlanetScale/ClearDB)
7. Click **Deploy**

### Step 3: Post-Deployment

```bash
# Run via Render Shell or add to startup command
php artisan storage:link
php artisan db:seed --force
```

### Using PlanetScale (Recommended for Render)

1. Create free account at [planetscale.com](https://planetscale.com)
2. Create database `ecommerce_pro`
3. Get connection credentials
4. Update `.env` with PlanetScale credentials
5. Set `DB_CONNECTION=mysql` and `MYSQL_ATTR_SSL_CA=/etc/ssl/cert.pem`

## Environment Variables Reference

```env
APP_NAME="E-Commerce Pro"
APP_ENV=production
APP_KEY=                    # Generated with artisan key:generate
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_pro
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=local       # Use 's3' for cloud storage
SESSION_DRIVER=file         # Use 'redis' in production
CACHE_DRIVER=file           # Use 'redis' in production

# For email verification (configure SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=yourpassword
```

## License

MIT License — Free for personal and commercial use.
