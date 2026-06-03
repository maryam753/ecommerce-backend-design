# 🛒 Laravel E-Commerce Platform

A full-featured e-commerce web application built using Laravel framework.  
This project provides a smooth shopping experience with authentication, product browsing, cart system, and secure checkout.

---

## 🚀 Features

- 👤 User Authentication (Login / Register)
- 🔐 Google Social Login (Laravel Socialite)
- 🛍️ Product Listing & Categories
- 🔎 Category-based Filtering
- 🛒 Add to Cart (AJAX based)
- ⚡ Buy Now Feature
- 💳 Checkout System
- 🎯 Modal-based Login/Register (No page reload)
- 📱 Fully Responsive UI
- 🔔 Toast Notifications for actions

---

## 🛠️ Tech Stack

- Laravel (PHP Framework)
- MySQL Database
- JavaScript (AJAX)
- HTML, CSS, Bootstrap
- Vite / Tailwind CSS (if used)

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

```bash
git clone https://github.com/your-username/laravel-ecommerce.git

cd laravel-ecommerce

composer install
npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
