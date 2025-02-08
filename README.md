
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

Now, follow these steps to clone and set up this project:

1. **Clone the repository:**  
   ```sh
   git clone https://github.com/devendra-dode/mini-ecommerce.git
   cd mini-ecommerce
   ```

2. **Install dependencies:**  
   ```sh
   composer clear-cache
   composer install && composer update
   ```

 
While running composer install or composer update, you may encounter an error indicating that the intl PHP extension is missing. This extension is required by the filament/support package.

Steps to Fix:

***Enable intl Extension in PHP***

Open C:\xampp\php\php.ini in a text editor.

Find this line:

   ```sh
    ;extension=intl
   ```
Remove the ; at the beginning to uncomment it:

   ```sh
    extension=intl
   ```
After completing these steps, try running composer install or composer update again.

3. **Configure Paypal:**  
   ```sh
   PAYPAL_MODE=sandbox  # Change to 'live' if using a live account
   PAYPAL_SANDBOX_CLIENT_ID=
   PAYPAL_SANDBOX_CLIENT_SECRET=
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

6. **Seed Products from API:**  
   ```sh
   php artisan sync:products
   ```

7. **Start the server:**  
   ```sh
   php artisan serve
   ```

Now, you can open your browser and visit http://127.0.0.1:8000 to access your Laravel application.

 **For Paypal dummy email and password:**  
   ```sh
   Email :- sb-egxqq37301256@business.example.com
   Password :- o+U7Q5fU
   ```

Visit: [http://127.0.0.1:8000/products](http://127.0.0.1:8000/products)
View Order List: [http://127.0.0.1:8000/admin/orders](http://127.0.0.1:8000/admin/orders)


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
