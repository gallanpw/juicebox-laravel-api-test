# Laravel API Test Submission

This is a Laravel-based API project for the technical test.

## 🚀 Setup Instructions

### 1️⃣ Clone Repository
```bash
git clone https://github.com/gallanpw/juicebox-laravel-api-test.git
cd juicebox-laravel-api-test
```

### 2️⃣ Install Dependencies
```bash
composer install
```

### 3️⃣ Setup Environment Variables
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=your_password

OPENWEATHER_API_KEY=your_api_key
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS="no-reply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 4️⃣ Migrate & Seed Database
```bash
php artisan migrate --seed
```

### 5️⃣ Run Laravel Server
```bash
php artisan serve
```

### 6️⃣ Run Queue Worker
```bash
php artisan queue:work
```

### 7️⃣ Run Schedule Worker
```bash
php artisan schedule:work
```

### 8️⃣ Manually Dispatch Welcome Email
```bash
php artisan email:welcome user@example.com
```

### 9️⃣ Run Tests
```bash
php artisan test
```

### 📝 API Documentation
https://documenter.getpostman.com/view/295836/2sAYkAR3a1