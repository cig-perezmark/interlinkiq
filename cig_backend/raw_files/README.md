
# Laravel 11 App (InterlinkIQ)

Container for All Backend Subsystems

## Install the dependencies
```bash
composer install
```

## Set up the environment
1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Generate the application key:
   ```bash
   php artisan key:generate
   ```

## Start the development server
```bash
php artisan serve
```

## Run the migrations
```bash
php artisan migrate
```

## Seed the database (optional)
```bash
php artisan db:seed
```

## Lint the PHP files
```bash
./vendor/bin/pint
```

## Customize the configuration
See the official [Laravel Documentation](https://laravel.com/docs/11.x).
