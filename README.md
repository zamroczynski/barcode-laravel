# Barcode Generator by Damian Zamroczynski

## Techstack

1. PHP
2. Laravel
3. SQLite
4. [php-barcode-generator](https://github.com/picqer/php-barcode-generator)

## Demo

[Click here!](http://188.68.242.194/)

## Installation

1. Requirements

[Laravel](https://laravel.com/docs/10.x/deployment#server-requirements) + php-sqlite3

2. Install dependencies

`composer install`

3. Copy .env file

`cp .env.example .env`

4. Make migrate

`php artisan migrate`

5. Generate key

`php artisan key:generate`

6. Run test

`php artisan test`

7. Run app

`php artisan serve`
