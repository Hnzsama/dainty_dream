# Dainty Dream (First Design)-Inventory Management System based on Boutique Shop

A modern, robust inventory management system built with Laravel 12 and Tailwind CSS. Designed specifically for retail businesses to efficiently manage inventory, track stock movements, and generate insightful reports.

## Overview

A comprehensive inventory management solution that automates stock tracking, supplier management, and transaction reporting. With real-time analytics and automatic stock synchronization, it provides businesses with complete visibility into their inventory operations.

## Key Features

- **Product Management** - Create and manage product catalog with automatic SKU generation
- **Category Organization** - Organize products into logical categories for easy browsing
- **Supplier Tracking** - Maintain supplier database with contact information and history
- **Customer Management** - Track customer details and purchase history
- **Incoming Stock Transactions** - Record stock purchases from suppliers with automatic stock updates
- **Outgoing Stock Transactions** - Track stock sales to customers with real-time inventory deduction
- **Real-time Analytics Dashboard** - Monitor KPIs including total products, stock value, and revenue trends
- **Monthly Reports** - Detailed stock movement analysis with Excel export functionality
- **User Authentication** - Secure login with role-based access control
- **Automatic Stock Synchronization** - Real-time inventory updates via Laravel Observers

## Technology Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| Backend Framework | Laravel | 12.0 |
| Frontend | Blade Templating + Tailwind CSS | 4.0 |
| Build Tool | Vite | 6.0 |
| Database | SQLite / MySQL | - |
| HTTP Client | Axios | 1.7.4 |
| PHP Version | PHP | 8.2+ |
| Testing Framework | PHPUnit | 11.5.3 |
| Package Manager | Composer | Latest |

## Project Structure

```
ProjectRPLS2/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Application controllers
│   │   └── Middleware/           # Authentication & authorization
│   ├── Models/                   # Eloquent models
│   ├── Observers/                # Automatic stock synchronization
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database schema migrations
│   ├── seeders/                  # Data seeding
│   └── schema.sql                # Complete database schema
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── auth/                 # Authentication views
│   │   ├── dashboard/            # Dashboard views
│   │   ├── products/             # Product management
│   │   ├── categories/           # Category management
│   │   ├── suppliers/            # Supplier management
│   │   ├── customers/            # Customer management
│   │   ├── incoming/             # Incoming transactions
│   │   ├── outgoing/             # Outgoing transactions
│   │   ├── stock-movements/      # Reports
│   │   └── users/                # User management
│   ├── css/                      # Stylesheets
│   └── js/                       # Frontend scripts
├── routes/
│   ├── web.php                   # Web application routes
│   └── console.php               # Console commands
├── tests/                        # PHPUnit tests
├── public/                       # Web server root
├── storage/                      # Logs and cache
├── vendor/                       # Composer dependencies
├── composer.json                 # PHP dependencies
├── package.json                  # NPM dependencies
├── vite.config.js               # Vite configuration
└── phpunit.xml                  # PHPUnit configuration
```

## Database Schema

### Core Models

| Model | Purpose | Key Fields |
|-------|---------|-----------|
| User | System authentication | email, password, phone |
| Product | Product catalog | sku, name, price, stock, category_id |
| Category | Product categorization | name |
| Supplier | Supplier information | name, address, phone |
| Customer | Customer information | name, address, phone |
| IncomingTransaction | Stock purchases | product_id, supplier_id, quantity, price, date |
| OutgoingTransaction | Stock sales | product_id, customer_id, quantity, price, date |

### Model Relationships

- Product belongs to Category and Supplier
- IncomingTransaction belongs to Product and Supplier
- OutgoingTransaction belongs to Product and Customer
- Transactions trigger automatic stock updates via Observers

## Installation Guide

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite or MySQL database

### Setup Steps

1. **Clone the repository**
   ```bash
   cd ProjectRPLS2
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run database migrations**
   ```bash
   php artisan migrate
   ```

6. **Build frontend assets**
   ```bash
   # Development mode with hot reload
   npm run dev
   
   # Production build
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## Configuration

### Environment Setup

Copy `.env.example` to `.env` and configure:

```env
APP_NAME=ProjectRPLS2
APP_ENV=local
DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite
SESSION_DRIVER=database
CACHE_STORE=database
```

### Default Credentials

- Email: `admin@dainty.com`
- Password: `123`

> Note: Change default credentials immediately in production environments.

## Core Features

### Dashboard Analytics

Real-time KPI monitoring including:
- Total products in inventory
- Total stock value calculation
- Monthly transaction volume trends
- Recent transaction history
- Revenue tracking

### Inventory Management

- Automatic SKU generation (SKU000001, etc.)
- Real-time stock level synchronization
- Bulk product import/export capabilities
- Category-based organization

### Transaction Tracking

**Incoming Transactions:**
- Record stock purchases from suppliers
- Automatic stock increment
- Unit price tracking
- Transaction date logging

**Outgoing Transactions:**
- Record sales to customers
- Automatic stock decrement
- Revenue calculation
- Customer history tracking

### Reporting & Analysis

- Monthly stock movement reports
- Supplier performance analysis
- Customer purchase history
- Excel export functionality
- Customizable date range filtering

### User Management

- Multi-user support with authentication
- User account creation and modification
- Session management
- Secure password storage

## API Routes Overview

### Public Routes
- `GET /login` - Login page
- `POST /login` - Login submission

### Protected Routes (Authenticated Users)

**Dashboard**
- `GET /dashboard` - Main analytics dashboard

**Products**
- `GET /products` - List all products
- `POST /products` - Create new product
- `GET /products/{id}/edit` - Edit product form
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product

**Categories**
- `GET /categories` - List categories
- `POST /categories` - Create category
- `PUT /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category

**Suppliers**
- `GET /suppliers` - List suppliers
- `POST /suppliers` - Create supplier
- `PUT /suppliers/{id}` - Update supplier
- `DELETE /suppliers/{id}` - Delete supplier

**Customers**
- `GET /customers` - List customers
- `POST /customers` - Create customer
- `PUT /customers/{id}` - Update customer
- `DELETE /customers/{id}` - Delete customer

**Incoming Transactions**
- `GET /incoming` - List incoming transactions
- `POST /incoming` - Create transaction (stock-in)
- `PUT /incoming/{id}` - Update transaction
- `DELETE /incoming/{id}` - Delete transaction

**Outgoing Transactions**
- `GET /outgoing` - List outgoing transactions
- `POST /outgoing` - Create transaction (stock-out)
- `PUT /outgoing/{id}` - Update transaction
- `DELETE /outgoing/{id}` - Delete transaction

**Reports**
- `GET /reports/monthly` - Monthly stock movement report
- `GET /reports/monthly?month=YYYY-MM-DD` - Report for specific month

**Users**
- `GET /users` - List users
- `POST /users` - Create user
- `PUT /users/{id}` - Update user
- `DELETE /users/{id}` - Delete user

**Authentication**
- `POST /logout` - Logout user

## Automatic Stock Synchronization

The system uses Laravel Observers for real-time inventory management:

### Incoming Transaction Observer
- **On Create:** Stock increases by transaction quantity
- **On Update:** Stock adjusted by quantity difference
- **On Delete:** Stock decreases by transaction quantity

### Outgoing Transaction Observer
- **On Create:** Stock decreases by transaction quantity
- **On Update:** Stock adjusted by quantity difference (reverse)
- **On Delete:** Stock increases by transaction quantity (reversal)

This ensures inventory is always accurate without manual intervention.

## Development

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/ProductTest.php

# Generate coverage report
php artisan test --coverage
```

### Code Standards

```bash
# Format code with Laravel Pint
php artisan pint
```

### Debugging

```bash
# Start Laravel Pail for real-time logs
php artisan pail

# Interactive shell
php artisan tinker
```

## Performance Optimization

- Database query optimization with eager loading
- Redis-compatible caching layer
- Vite for fast frontend builds
- SQL indexing on foreign keys
- Automatic query pagination

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Security Features

- Secure password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Session-based authentication
- Middleware-based authorization

## License

This project is proprietary software. All rights reserved.

## Support & Contribution

For support or to report bugs, please contact the development team.

