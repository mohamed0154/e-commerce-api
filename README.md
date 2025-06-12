# E-Commerce RESTful API - Laravel

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A secure and scalable RESTful API for e-commerce platforms built with Laravel framework.

## ✨ Features

### 🔐 Authentication & Authorization
- **Multi-authentication system** (Users & Admins)
- **Email verification** for user accounts
- **Role-Based Access Control (RBAC)** via middleware
- **Bearer token authentication** for secure API access

### 🗃️ Database & Product Management
- **Optimized relational database schemas** for:
  - Categories & Subcategories
  - Products & Brands
- **Full CRUD operations** using Eloquent ORM
- **Efficient query relationships** and eager loading

### 🛒 Shopping Experience
- **Shopping cart management**:
  - Add/Update/Remove items
  - Quantity adjustments
  - Session-based cart persistence
- **User-centric functionalities** with clean API design

### 🛡️ Security & Architecture
- **Route protection** with middleware
- **Admin/user access restrictions**
- **Robust validation** and error handling
- **Scalable architecture** following best practices

## 🚀 Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/ecommerce-api.git

# Install dependencies
composer install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --seed

# Start development server
php artisan serve
