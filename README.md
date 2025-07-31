# 🏢 Enterprise ERP System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.1+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/Docker-Ready-blue.svg" alt="Docker Ready">
</p>

A comprehensive, secure, and scalable **Enterprise Resource Planning (ERP)** system built with Laravel 11. This system features a modular architecture, bilingual interface (Arabic/English), and robust Role-Based Access Control (RBAC).

## 🌟 Features

- **🔐 Advanced Authentication & RBAC**: Secure user management with granular permissions
- **🌍 Bilingual Interface**: Full Arabic and English support with language toggle
- **📱 Responsive Design**: Bootstrap 5-powered responsive interface
- **🐳 Docker Ready**: Complete containerization for easy deployment
- **⚡ High Performance**: Optimized Laravel application with caching
- **🔧 Modular Architecture**: 18 integrated business modules

## 📋 System Modules

### Core Business Modules
1. **🏘️ Real Estate Investment Management** - Property portfolio and ROI tracking
2. **🏗️ Technical Office** - Project planning, BoQ, and design management
3. **📄 Contracts Management** - Contract lifecycle and milestone tracking
4. **💰 Financial Management** - Complete accounting and financial reporting
5. **🏭 Assets & Equipment Management** - Asset tracking and maintenance
6. **🛒 Purchases & Stores Management** - Procurement and inventory control
7. **👥 Human Resources Management** - Employee lifecycle and payroll
8. **🔧 Maintenance & Operation** - Work orders and preventive maintenance
9. **🤝 Partner Management** - Business partnerships and joint ventures
10. **📁 Documents & Records** - Centralized document repository
11. **📅 Secretarial Management** - Meeting and task coordination
12. **🏛️ Public Administration** - Compliance and official correspondence
13. **👷 Subcontractors Department** - Vendor management and evaluation

### System-Wide Modules
14. **📊 Reports Department** - Cross-module reporting and analytics
15. **⚠️ Risk Management Department** - Risk assessment and mitigation
16. **🦺 Health & Safety Department** - Incident tracking and safety compliance
17. **⚙️ System Settings** - Configuration and customization
18. **👤 User Management & Security** - RBAC and user administration

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM (for asset compilation)
- SQLite/MySQL/PostgreSQL

### Local Installation

```bash
# Clone the repository
git clone https://github.com/AmrElsayed-1994/enterprise-erp-system.git
cd enterprise-erp-system

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite

# Run migrations and seed data
php artisan migrate --seed

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` to access the system.

## 🔑 Demo Credentials

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| **Super Admin** | `superadmin@erp.com` | `password` | Full system access |
| **Admin** | `admin@erp.com` | `password` | Administrative access |
| **Demo User** | `demo@erp.com` | `password` | Limited module access |

## 🐳 Docker Deployment

### Using Docker Compose (Recommended)

```bash
# Clone and navigate to project
git clone https://github.com/AmrElsayed-1994/enterprise-erp-system.git
cd enterprise-erp-system

# Start with Docker Compose
docker-compose up -d

# Access the application
open http://localhost:8080
```

### Manual Docker Build

```bash
# Build the Docker image
docker build -t enterprise-erp .

# Run the container
docker run -d -p 8080:80 --name erp-system enterprise-erp

# Access the application
open http://localhost:8080
```

## ☁️ Cloud Deployment

### Deploy to Railway

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/AmrElsayed-1994/enterprise-erp-system)

1. Click the "Deploy on Railway" button
2. Connect your GitHub account
3. Configure environment variables
4. Deploy automatically

### Deploy to Heroku

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/AmrElsayed-1994/enterprise-erp-system)

1. Click "Deploy to Heroku"
2. Configure app name and region
3. Set environment variables
4. Deploy the application

### Manual Cloud Deployment

#### Environment Variables for Production

```env
APP_NAME="Enterprise ERP System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_KEY=base64:your-generated-key

# Database (choose one)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

# OR MySQL
# DB_CONNECTION=mysql
# DB_HOST=your-mysql-host
# DB_DATABASE=enterprise_erp
# DB_USERNAME=your-username
# DB_PASSWORD=your-password

# OR PostgreSQL (Heroku)
# DB_CONNECTION=pgsql
# DATABASE_URL=postgres://user:pass@host:port/db

# Session Security
SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=your-domain.com
SESSION_SAME_SITE=lax

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

## 🏗️ Architecture

### Database Schema
- **Users & Roles**: RBAC implementation with granular permissions
- **Modules**: Each business module has dedicated tables and relationships
- **Audit Trail**: Comprehensive logging and activity tracking
- **Multi-tenancy Ready**: Designed for future multi-tenant expansion

### Security Features
- **CSRF Protection**: Laravel's built-in CSRF protection
- **SQL Injection Prevention**: Eloquent ORM with prepared statements
- **XSS Protection**: Input sanitization and output escaping
- **Session Security**: Secure session handling with HTTPS
- **Password Hashing**: Bcrypt password hashing

### Performance Optimizations
- **Database Indexing**: Optimized database queries
- **Caching**: Redis/File-based caching support
- **Asset Optimization**: Minified CSS/JS assets
- **Lazy Loading**: Efficient data loading strategies

## 🔧 Configuration

### Environment Configuration

The system supports multiple database configurations:

**SQLite (Default - Recommended for small deployments)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

**MySQL (Recommended for production)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=enterprise_erp
DB_USERNAME=erp_user
DB_PASSWORD=secure_password
```

**PostgreSQL (Heroku/Cloud)**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=enterprise_erp
DB_USERNAME=erp_user
DB_PASSWORD=secure_password
```

### Module Permissions

Each module has specific permissions:
- `view_[module]` - View module dashboard and data
- `create_[module]` - Create new records
- `edit_[module]` - Edit existing records
- `delete_[module]` - Delete records

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 📚 API Documentation

The system includes a RESTful API for future mobile app integration:

```bash
# Generate API documentation
php artisan l5-swagger:generate

# Access API docs at /api/documentation
```

## 🛠️ Development

### Adding New Modules

1. Create migration files
2. Create model with relationships
3. Create controller with CRUD operations
4. Create views following the existing pattern
5. Add routes and permissions
6. Update navigation menu

### Customization

- **Themes**: Modify `resources/sass/app.scss`
- **Languages**: Add translations in `resources/lang/`
- **Modules**: Follow the modular architecture pattern
- **Permissions**: Update `PermissionSeeder.php`

## 🔍 Troubleshooting

### Common Issues

**Permission Denied Errors**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Database Connection Issues**
```bash
# Check database file exists (SQLite)
touch database/database.sqlite

# Verify database credentials
php artisan tinker
DB::connection()->getPdo();
```

**Session Issues**
```bash
# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan session:clear
```

### Performance Issues

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📞 Support

For support and questions:
- 📧 Email: support@enterprise-erp.com
- 📖 Documentation: [Wiki](https://github.com/AmrElsayed-1994/enterprise-erp-system/wiki)
- 🐛 Issues: [GitHub Issues](https://github.com/AmrElsayed-1994/enterprise-erp-system/issues)

## 🎯 Roadmap

- [ ] Mobile application (React Native)
- [ ] Advanced reporting dashboard
- [ ] Multi-tenant architecture
- [ ] API rate limiting
- [ ] Real-time notifications
- [ ] Advanced workflow automation
- [ ] Integration with external services

---

**Built with ❤️ using Laravel 11 | Created by [Devin AI](https://app.devin.ai/sessions/98f2ceb40a3c464fbf451d030e5c870e) for [@AmrElsayed-1994](https://github.com/AmrElsayed-1994)**
