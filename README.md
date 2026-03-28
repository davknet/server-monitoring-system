<<<<<<< HEAD
# server-monitoring-system
The project was created for an assignment 
=======
Server Monitoring System

This project allows you to monitor servers via multiple protocols (HTTP, HTTPS, FTP, SSH) and log health checks automatically.

Prerequisites
PHP ≥ 8.1
Composer
MySQL or MariaDB
Git
Node.js & npm (optional, if you plan to compile assets)
1. Clone the Repository
git clone https://github.com/<your-username>/<repository-name>.git
cd <repository-name>
2. Install Dependencies
composer install

This will install all Laravel packages.

3. Environment Setup
Copy .env.example to .env:
cp .env.example .env
Edit .env to set database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=server_monitoring
DB_USERNAME=root
DB_PASSWORD=
4. Generate Application Key
php artisan key:generate
5. Run Migrations and Seed Database
php artisan migrate --seed

This will:

Create all tables, including servers and request_tests.
Insert a default user with:
Email: test@example.com
Password: 123456
6. Serve the Application
php artisan serve

This will start a local server (usually at http://127.0.0.1:8000). Open it in your browser.

7. Log in and Test
Login using the seeded user (test@example.com / 123456).
Go to Add Server page.
Add a server with proper URL, IP, protocol, and optional username/password if required.
The server will appear in the health check table on the Home/Dashboard page.
8. Run Scheduled Server Checks

Laravel uses scheduling instead of traditional cron jobs. To start the scheduler:

php artisan schedule:work

Why schedule:work is better than cron:

Runs immediately in your current environment without editing crontab.
Uses Laravel's scheduler logic, making it easier to manage multiple scheduled tasks.
Logs failures automatically.
Portable across different environments and development machines.
9. Optional: Installing Artisan

Artisan is bundled with Laravel, so if you have composer install completed, you already have it. Check:

php artisan --version

If PHP is installed but you don’t see artisan, make sure you are in the project root and have PHP CLI available in your PATH.

10. Notes
Use php artisan migrate:fresh --seed if you want to reset the database and reseed.
The server health table updates automatically every 10 seconds via AJAX.
Use php artisan schedule:work in a separate terminal to continuously run background checks.

✅ With these steps, a new developer can clone the project, run migrations, seed the database, start the server, log in, add servers, and watch automated health checks in real-time.

If you want, I can also add a small diagram or workflow explanation for the README showing how servers → checks → request_tests → AJAX updates, which makes it much easier to understand for new developers.

Do you want me to create that diagram?


