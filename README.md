## About Our Project

Raivo is gay

Nonetheless
For future step by step guide:

composer create-project laravel/laravel @YourProject@

cd @YourProject@

copy .env.example .env (when needed from cloning)

then php artisan key:generate

Personally prefer sqlite so my steps differ aka (create the file database/database.sqlite un database folder)

In .env set: DB_CONNECTION=sqlite

Once db is created c=: php artisan migrate

## Auth part

composer require laravel/breeze --dev

php artisan breeze:install

When prompted, choose: Blade ; dark mode (optional) ; Yes to PHPUnit 

php artisan migrate again

npm install

npm run dev
