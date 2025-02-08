
# Mini eCommerce System in Laravel 11

---

## Features Overview
- **Product Syncing:** Fetches products from `https://fakestoreapi.com/products` and avoids duplication.
- **Session-Based Cart:** Allows adding, updating, and removing items.
- **Order & Payment Handling:** Integrates PayPal for payments and stores orders.
- **Admin Management:** Uses Filament for managing orders and tracking payments.

---

## Tech Stack
- **Backend:** Laravel 11
- **Database:** MySQL
- **Frontend:** Blade Templates
- **Cart:** Session-based
- **Payment:** PayPal SDK
- **Admin Panel:** Filament

---

## XAMPP Installation & Setup
- Download XAMPP from apachefriends.org.
- Install XAMPP and select Apache, MySQL, and PHP components.
- Open XAMPP Control Panel and start Apache and MySQL.
- Verify Installation by visiting http://localhost/phpmyadmin in a browser.

## Create Database
- Run this command to create database
```sh
CREATE DATABASE ecommerce;
```

## Project Setup

### Requirements
- PHP 8.1+
- Composer
- MySQL
- Laravel 11
- Filament Admin Panel
- PayPal SDK

### Installation

**Navigate to XAMPP/htdocs**  
Open the command prompt and run the following command to navigate to the `xampp/htdocs` directory:

```sh
cd xampp/htdocs
```

1. **Clone the repository:**  
   ```sh
   git clone https://github.com/devendra-dode/mini-ecommerce.git
   cd mini-ecommerce
   ```

2. **Install dependencies:**  
   ```sh
   composer install
   ```

3. **Setup environment:**  
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database:** (Update `.env` file)  
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations:**  
   ```sh
   php artisan migrate
   ```

6. **Install and setup Filament:**  
   ```sh
   composer require filament/filament
   php artisan filament:install
   ```

7. **Seed Products from API:**  
   ```sh
   php artisan fetch:products
   php artisan sync:products
   ```

8. **Start the server:**  
   ```sh
   php artisan serve
   ```

---

## Routes & Functionalities

### Public Routes
- **Fetch and Display Products:**
  - `GET /products` → Show all products from database
- **Shopping Cart:**
  - `POST /cart/add/{id}` → Add product to cart
  - `GET /cart` → View cart
  - `POST /cart/update/{id}` → Update item quantity
  - `POST /cart/remove/{id}` → Remove item from cart
- **Checkout & Payment:**
  - `GET /checkout` → Show checkout page
  - `POST /checkout/pay` → Process PayPal payment
- **Order Summary:**
  - `GET /order/{transactionId}` → Show order details

### Admin Routes (Filament)
- **Manage Orders:**
  - `GET /admin/orders` → List all orders
  - `GET /admin/orders/{id}` → View order details


## Run Locally
```sh
php artisan serve
```
Visit: [http://127.0.0.1:8000/products](http://127.0.0.1:8000/products)
View Order List: [http://127.0.0.1:8000/admin/orders](http://127.0.0.1:8000/admin/orders)
