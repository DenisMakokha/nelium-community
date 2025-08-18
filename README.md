# Nelium Community Platform

A comprehensive community management platform built with Laravel API backend and Vue.js frontend, featuring complete CRUD operations for members, events, resources, and announcements.

## ✨ Features

### Admin Dashboard
- **Members Management** - Full CRUD with search, filtering, and pagination
- **Events Management** - Create, edit, delete events with location types (online/physical/hybrid)
- **Resources Management** - File upload system with categories and tier-based access
- **Announcements** - Priority-based announcement system with scheduling
- **Audit Logging** - Complete activity tracking for admin actions
- **Reports & Analytics** - Dashboard with statistics and insights

### Core Functionality
- User authentication and role-based authorization
- Payment processing with Flutterwave integration
- File upload and storage system
- Real-time data updates
- Responsive design with modern UI

## 🛠 Tech Stack

### Backend (API)
- **Laravel 10** - PHP framework
- **MySQL** - Database
- **Sanctum** - API authentication
- **Spatie Roles & Permissions** - Authorization
- **Laravel Storage** - File management

### Frontend (Web)
- **Vue 3** with Composition API
- **TypeScript** - Type safety
- **Vite** - Build tool
- **Tailwind CSS** - Styling
- **Pinia** - State management
- **Axios** - HTTP client

## 🚀 Getting Started

### Prerequisites
- PHP 8.1+
- Node.js 16+
- MySQL 8.0+
- Composer

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/nelium-community.git
cd nelium-community
```

2. **Backend Setup**
```bash
cd api
composer install
cp .env.example .env
# Configure your database and other settings in .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

3. **Frontend Setup**
```bash
cd ../web
npm install
cp .env.example .env.local
# Configure API_BASE_URL in .env.local
npm run dev
```

### Environment Variables

**Backend (.env)**
```env
DB_DATABASE=nelium_community
DB_USERNAME=your_username
DB_PASSWORD=your_password
FLUTTERWAVE_PUBLIC_KEY=your_flutterwave_public_key
FLUTTERWAVE_SECRET_KEY=your_flutterwave_secret_key
```

**Frontend (.env.local)**
```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
VITE_FLUTTERWAVE_PUBLIC_KEY=your_flutterwave_public_key
```

## 📁 Project Structure

```
nelium-community/
├── api/                          # Laravel backend
│   ├── app/
│   │   ├── Http/Controllers/     # API controllers
│   │   ├── Models/              # Eloquent models
│   │   └── Console/Commands/    # Artisan commands
│   ├── database/
│   │   ├── migrations/          # Database migrations
│   │   └── seeders/            # Database seeders
│   └── routes/api.php          # API routes
├── web/                         # Vue.js frontend
│   ├── src/
│   │   ├── components/         # Vue components
│   │   ├── views/             # Page components
│   │   ├── services/          # API services
│   │   └── stores/           # Pinia stores
│   └── public/               # Static assets
└── README.md
```

## 🔧 Key Features Implemented

### ✅ Completed
- Members CRUD with search and filtering
- Events management with location types
- Resources with file upload and categories
- Announcements with priority levels
- Database schema with audit logging
- Admin authentication and authorization
- Responsive UI with Tailwind CSS

### 🚧 In Progress
- Payment refund functionality
- Enhanced reports with charts
- Email notification system
- End-to-end testing

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel community for the excellent framework
- Vue.js team for the reactive frontend framework
- Tailwind CSS for the utility-first CSS framework