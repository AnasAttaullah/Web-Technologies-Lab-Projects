# Laravel E-Commerce CRUD Application

A complete CRUD application for managing an e-commerce store with customers, products, orders, and order details.

## Features

### 1. **Customers Management**
- Create, read, update, and delete customers
- Fields: name, email, phone, address
- View customer orders history
- Unique email validation

### 2. **Products Management**
- Create, read, update, and delete products
- Fields: name, description, price, stock
- Stock tracking and management
- Price validation

### 3. **Orders Management**
- Create, read, update, and delete orders
- Link orders to customers
- Order status tracking (pending, processing, completed, cancelled)
- Add multiple products to an order
- Automatic total calculation
- Automatic stock adjustment

### 4. **Order Details Management**
- Create, read, update, and delete order details
- Link to specific orders and products
- Quantity and price tracking
- Automatic subtotal calculation
- Stock management on creation/update/deletion

## Database Schema

### Customers Table
- id (primary key)
- name
- email (unique)
- phone
- address
- created_at, updated_at

### Products Table
- id (primary key)
- name
- description
- price
- stock
- created_at, updated_at

### Orders Table
- id (primary key)
- customer_id (foreign key)
- order_date
- total_amount
- status (pending|processing|completed|cancelled)
- created_at, updated_at

### Order Details Table
- id (primary key)
- order_id (foreign key)
- product_id (foreign key)
- quantity
- price
- subtotal
- created_at, updated_at

## Relationships

- Customer → Orders (One to Many)
- Order → Customer (Belongs To)
- Order → Order Details (One to Many)
- Order Detail → Order (Belongs To)
- Product → Order Details (One to Many)
- Order Detail → Product (Belongs To)

## Installation & Setup

1. **Database Configuration**
   - Database: `crud1` (MySQL)
   - Already configured in `.env` file

2. **Run Migrations**
   ```bash
   php artisan migrate:fresh --seed
   ```
   This will create all tables and populate them with sample data.

3. **Start Laravel Development Server**
   ```bash
   php artisan serve
   ```
   Access the application at: `http://localhost:8000`

## Sample Data

The seeder creates:
- 5 sample customers
- 10 sample products
- 3 sample orders with order details
- Proper stock adjustments

## Navigation

The application includes a top navigation bar with links to:
- Customers
- Products
- Orders
- Order Details

## Key Features

### Smart Stock Management
- Stock is automatically decreased when orders/order details are created
- Stock is restored when orders/order details are deleted
- Stock validation prevents overselling

### Automatic Calculations
- Order totals are calculated automatically from order details
- Subtotals are calculated based on quantity × price
- Prices are captured at the time of order creation

### User-Friendly Interface
- Bootstrap 5 styling
- Responsive design
- Icons for actions
- Success/error messages
- Form validation
- Confirmation dialogs for deletions

### Cascading Deletes
- Deleting an order automatically deletes its order details
- Deleting a customer automatically deletes their orders

## Routes

All CRUD routes are registered as resource routes:
- `/customers` - Customer management
- `/products` - Product management
- `/orders` - Order management
- `/order-details` - Order detail management

Each resource has the standard RESTful routes:
- `index` - List all
- `create` - Show create form
- `store` - Save new record
- `show` - View details
- `edit` - Show edit form
- `update` - Update record
- `destroy` - Delete record

## Technologies Used

- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Bootstrap 5** - CSS Framework
- **Bootstrap Icons** - Icon Library
- **Blade** - Template Engine

## Author

Created with GitHub Copilot CLI

## License

Open source - feel free to use and modify as needed.
