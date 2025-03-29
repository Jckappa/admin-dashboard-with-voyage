# Laravel Project Setup with Voyager

## Prerequisites
Before starting, ensure you have the following installed on your system:

- PHP (>=8.0)
- Composer
- MySQL or MariaDB
- XAMPP (Optional, for local development)
- Node.js & npm (for frontend assets, if needed)

## Step 1: Clone the Project from Repository
```bash
git clone https://github.com/Jckappa/admin-dashboard-with-voyage.git
cd my-admin-dashboard
```

## Step 2: Install Dependencies
```bash
composer install
npm install
```

## Step 3: Configure Environment
Copy the example environment file and update the database settings:
```bash
cp .env.example .env
```
Edit the `.env` file:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voyager_db
DB_USERNAME=root
DB_PASSWORD=
```

## Step 4: Generate Application Key
```bash
php artisan key:generate
```

## Step 5: Run Migrations and Seed Database
```bash
php artisan migrate --seed
```

## Step 6: Serve the Application
```bash
php artisan serve
```
Access Voyager Admin Panel at: `http://localhost/admin`

## Additional Commands
- **Clear Cache:** `php artisan cache:clear`
- **Link Storage:** `php artisan storage:link`

## Troubleshooting
- If installation fails, ensure your PHP version is correct and update Composer dependencies:
  ```bash
  composer update
  ```

