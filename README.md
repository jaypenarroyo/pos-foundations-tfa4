# POS Foundations TFA4

A complete CodeIgniter 4 Point-of-Sale foundation with MySQL persistence, customer and user management, sessions, hashed passwords, authentication, and protected routes.

## TFA4 requirements completed

- Added a `password` column to the `users` table
- Passwords are created with PHP `password_hash()`
- Login verifies stored hashes with `password_verify()`
- Successful login regenerates the session ID and stores authenticated user data
- `AuthFilter` redirects unauthenticated visitors to `/login`
- Customer and user list, new, edit, update, and delete routes require login
- Logout destroys the session and redirects to the login page
- Forms use session-based CSRF protection
- Database export, migrations, and seeder files are included
- Automated tests verify authentication, access control, password hashing, and database-backed pages

## Included management features

Because TFA4 builds on TFA3, this project also includes customer and user create, read, update, and delete actions with validation.

## Requirements

- PHP 8.2 or newer
- Composer 2
- MySQL or MariaDB, such as XAMPP MySQL
- PHP extensions `intl`, `mbstring`, and `mysqli`

## Quick setup with XAMPP

1. Extract or clone the project.
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import** and choose `database/pos_database.sql`.
5. Copy `env` to `.env` if `.env` is absent:

```powershell
Copy-Item env .env
```

6. Confirm the following values in `.env`:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = pos_database
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

7. Restore Composer dependencies:

```powershell
composer install
```

8. Start the application:

```powershell
php spark serve
```

9. Open `http://localhost:8080/login`.

## Demo login

```text
Username: admin
Password: Password123!
```

All five seeded accounts use the same demo password. Change these credentials before deploying the application publicly.

## Alternative setup with migrations

Create an empty database named `pos_database`, configure `.env`, and run:

```powershell
php spark migrate
php spark db:seed PosSeeder
php spark serve
```

## Routes

Public routes:

- `GET /`
- `GET /about`
- `GET /login`
- `POST /login`

Authenticated routes:

- `POST /logout`
- Customer list, new, create, edit, update, and delete routes
- User list, new, create, edit, update, and delete routes

Confirm the configured routes and filters:

```powershell
php spark routes
php spark filter:check get customers
php spark filter:check get users
```

## Automated tests

The test suite uses an in-memory SQLite database and does not modify local MySQL data. Enable PHP's `sqlite3` extension before running:

```powershell
vendor\bin\phpunit --no-coverage
```

## Important files

```text
app/
  Config/Filters.php
  Config/Routes.php
  Config/Security.php
  Controllers/Auth.php
  Controllers/Customers.php
  Controllers/Users.php
  Filters/AuthFilter.php
  Models/CustomerModel.php
  Models/UserModel.php
  Database/Migrations/2026-10-09-120000_CreatePosTables.php
  Database/Migrations/2026-10-09-130000_AddPasswordToUsers.php
  Database/Seeds/PosSeeder.php
  Views/auth/login.php
  Views/customers/
  Views/users/
database/
  pos_database.sql
```

## GitHub notes

The `.gitignore` excludes `.env` and `vendor`. This is intentional: database credentials must not be committed, and Composer recreates dependencies from `composer.lock`. The safe `env` template and required SQL export are included in the repository.

## Hosting notes

1. Use PHP 8.2+ hosting with MySQL and the required extensions.
2. Point the website document root to `public`.
3. Run `composer install --no-dev`.
4. Import `database/pos_database.sql` or run the migrations and seeder.
5. Create a production `.env` using the host's database credentials.
6. Set `CI_ENVIRONMENT = production` and configure the final HTTPS base URL.
7. Make `writable` writable by the web server.
8. Replace all demo passwords before making the application public.
