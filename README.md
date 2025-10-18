# POS-Inventory Management System

A comprehensive, web-based Point of Sale system built with PHP, MySQL, and Bootstrap. This system provides complete inventory management, sales tracking, customer management, and reporting capabilities for retail businesses.

## 🚀 Features

### Core Functionality
- **User Management** - Admin and employee access levels
- **Product Management** - Complete inventory control with categories
- **Sales Management** - Point of sale transactions with multiple payment methods
- **Customer Management** - Customer database and purchase history
- **Reporting System** - Sales reports, analytics, and data export
- **Receipt Generation** - PDF receipt printing and XML data export

### Advanced Features
- **Stock Management** - Automatic stock deduction and low-stock alerts
- **Tax Calculation** - Configurable tax rates
- **Profit Margin** - Automatic selling price calculation
- **Payment Methods** - Cash, Credit Card, and Debit Card support
- **Search & Filter** - Advanced search across all modules
- **Responsive Design** - Mobile-friendly interface

## 📋 Requirements

- **PHP Version:** 5.6 or higher
- **Database:** MySQL 5.6 or higher
- **Web Server:** Apache (XAMPP recommended)
- **Browser:** Modern web browser with JavaScript enabled

## 🛠️ Installation

### Step 1: Download and Setup
1. Download the POS system files
2. Extract to your web server directory (e.g., `C:\xampp\htdocs\POS-PHP\`)

### Step 2: Database Setup
1. Start XAMPP (Apache and MySQL services)
2. Open phpMyAdmin (`http://localhost/phpmyadmin`)
3. Create a new database named `posystem`
4. Import the database file: `DATABASE FILE/posystem.sql`

### Step 3: Configuration
1. Ensure XAMPP services are running
2. Access the system at `http://localhost/POS-PHP/`

## 🔐 Login Credentials

**Default Admin Login:**
- **Username:** `admin`
- **Password:** `admin`

## 📖 User Guide

### Admin Panel Features

#### Dashboard
- View total sales, products, customers, and categories
- Access recent sales and product information
- Monitor system statistics

#### Product Management
1. **Add Categories** - Create product categories
2. **Add Products** - Add new products with:
   - Product code and description
   - Buying and selling prices
   - Stock quantity
   - Category assignment
   - Product images

#### Sales Management
1. **Create Sale** - Process new transactions:
   - Select customer (new or existing)
   - Add multiple products
   - Set quantities
   - Apply tax rates
   - Choose payment method
   - Generate receipt

2. **Manage Sales** - View, edit, or delete existing sales

#### Customer Management
- Add new customers with contact information
- View customer purchase history
- Track customer transactions

#### User Management
- Create employee accounts
- Set access levels (Admin/Employee)
- Manage user permissions

#### Reports
- **Sales Reports** - Daily, weekly, monthly sales data
- **Product Reports** - Best-selling products
- **Customer Reports** - Top customers
- **Seller Reports** - Employee performance
- **Export Options** - PDF and XML formats

### Employee Panel Features
Employees have limited access to:
- View and create sales
- Manage customers
- Print receipts
- View basic reports
- Update customer information

## 🗂️ File Structure

```
POS-PHP/
├── ajax/                    # AJAX handlers
├── controllers/             # PHP controllers
├── models/                  # Database models
├── views/                   # Frontend views
│   ├── modules/            # Main application pages
│   ├── js/                # JavaScript files
│   ├── css/               # Stylesheets
│   └── img/               # Images and assets
├── extensions/             # Third-party libraries
├── DATABASE FILE/          # Database schema
└── index.php              # Main entry point
```

## 🔧 Technical Details

### Database Tables
- `users` - User accounts and authentication
- `products` - Product inventory
- `categories` - Product categories
- `customers` - Customer information
- `sales` - Sales transactions

### Security Features
- Password hashing with salt
- Session management
- Input validation
- SQL injection prevention
- XSS protection

### Payment Methods
- **Cash** - Direct cash payments
- **Credit Card** - Credit card transactions
- **Debit Card** - Debit card transactions

## 📊 Reporting Features

### Available Reports
1. **Sales Graph** - Visual sales data representation
2. **Best Selling Products** - Top-performing products
3. **Top Customers** - Customer purchase analysis
4. **Seller Performance** - Employee sales tracking
5. **Sales Report** - Detailed transaction reports

### Export Options
- **PDF Receipts** - Professional receipt printing
- **XML Export** - Data export for external systems

## 🎨 Customization

### Branding
- Custom logo support
- Color scheme customization
- Company information display

### Configuration
- Tax rate settings
- Profit margin calculations
- Currency formatting
- Date/time settings

## 🚨 Troubleshooting

### Common Issues

#### Login Problems
- Verify username: `admin`
- Verify password: `admin`
- Check database connection
- Ensure XAMPP services are running

#### Database Connection Issues
- Verify MySQL service is running
- Check database name: `posystem`
- Verify database credentials

#### File Permission Issues
- Ensure web server has read/write access
- Check file permissions on upload directories

### Error Messages
- **"User or password incorrect"** - Check login credentials
- **"Database connection failed"** - Verify MySQL service
- **"File not found"** - Check file paths and permissions

## 🔄 Updates and Maintenance

### Regular Maintenance
- Backup database regularly
- Update product information
- Review sales reports
- Monitor system performance

### Data Backup
- Export database regularly
- Backup uploaded files
- Keep system backups

## 📞 Support

For technical support or questions:
1. Check this README file
2. Review error messages
3. Verify system requirements
4. Check database connectivity

## 📄 License

This POS system is provided for educational and commercial use. Please ensure compliance with your local regulations and licensing requirements.

## 🎯 System Benefits

- **Easy to Use** - Intuitive interface for all skill levels
- **Complete Solution** - All-in-one POS system
- **Scalable** - Suitable for small to medium businesses
- **Cost Effective** - No monthly fees or subscriptions
- **Customizable** - Adaptable to specific business needs
- **Reliable** - Stable and tested system

---

**Version:** 1.0  
**Last Updated:** October 2025  
**Compatibility:** PHP 5.6+, MySQL 5.6+, Modern Browsers
