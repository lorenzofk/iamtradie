# 🚀 Laravel SaaS Kit

A clean, modern boilerplate to kickstart your next Laravel SaaS project.

## ⚙️ Tech Stack

- **Laravel 12**
- **Inertia.js** + **Vue 3**
- **Tailwind CSS**
- **PrimeVue 4**
- **MySQL**
- **Ziggy** (for client-side route helpers)
- **PHPUnit** for testing
- **Laravel Telescope** for local debugging
- **Log Viewer** for production-ready log management

## ✅ Features

- 🔐 Auth (Login, Logout, Reset Password)
- 🧱 Sidebar layout included
- 🎨 Theming & custom colours (Tailwind + PrimeVue)
- 🧪 Ready for tests with PHPUnit
- ⚡ Clean structure to fork and ship fast
- 📊 Integrated Log Viewer with production-ready security

## 🧑‍💻 Getting Started

```bash
git clone https://github.com/your-username/laravel-saas-kit.git
cd laravel-saas-kit
cp .env.example .env
composer install
npm install && npm run dev
php artisan key:generate
```

## 📊 Log Viewer

This application includes an integrated Log Viewer (opcodesio/log-viewer) for monitoring application logs in production.

### Access

- **Local Development**: Access at `http://your-app.test/log-viewer` (no authentication required)
- **Production**: Access at `https://your-domain.com/log-viewer` (authentication required)

### Security Features

- ✅ Authentication required in production environment
- ✅ Gate-based authorization for additional security layers
- ✅ Custom middleware for fine-grained access control
- ✅ Only exposes Laravel application logs (system logs hidden for security)
- ✅ Configurable environment-based access controls

### Configuration

The log viewer configuration is located in `config/log-viewer.php`. Key security settings:

- Authentication is enforced in non-local environments
- Uses custom `EnsureUserCanViewLogs` middleware
- Gate authorization via `viewLogViewer` gate
- Only includes `*.log` files from the application

### Customization

To customize access permissions, modify:
- `app/Http/Middleware/EnsureUserCanViewLogs.php` - Middleware authorization
- `app/Providers/AppServiceProvider.php` - Gate definition
- `config/log-viewer.php` - General configuration

Built with ☕ by Lorenzo.