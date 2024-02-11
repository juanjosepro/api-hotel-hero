# [Hotel Management System API](#)

![version](https://img.shields.io/badge/version-1.0.0-blue.svg)

>See demo [Api hotel hero](http://api.hotel.juanjosepau.dev "See demo")

>See demo [Frontend hotel hero](http://hotel.juanjosepau.dev "See demo")

### REQUIREMENTS DEVELOPMENT SETUP
``` bash
composer 2.5.8 # or any version no difference

php 7.3 # or php.7.4 not tested

mysql or postgresql
```

### DEVELOPMENT SETUP
``` bash
# comand basic
composer install

cp .env.example .env

php artisan key:generate

php artisan storage:link

# comand migrate table or tables with seeders
php artisan migrate
# or
php artisan migrate --seed

# configure variables .env
# Prod -> hotel.com
# Dev -> localhost:9000 [frontend]
SANCTUM_STATEFUL_DOMAINS=localhost:9000

#Prod -> api.hotel.com
#Dev -> localhost [api]
SESSION_DOMAIN=localhost

# lauch api
php artisan serve
# or
php artisan serve --host localhost
```


### CONFIGURATION FOR DEPLOYMENT IN CPANEL OR PLESK

- Clone the repository locally (development)

    ``` bash
    # run commands
    > composer install
    > cp .env.example .env
    > php artisan key:generate

    #optional
    > install `fakerphp/faker` to run the seeders in production:
        composer require fakerphp/faker
    ```

- Compress the project into ZIP and upload the project to cpanel or plesk, do the following:

- It is necessary to redirect the start of the program to the `public/` folder in Plesk, it is necessary to create an .htaccess file with the following content:

    ``` bash
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>
    ```

- Create the symbolic link (images) by accessing the following path:
    > https://api.hotel.domain.dev/commands/php-artisan-storage-link

- To create the database

- Configure the `.env` file

    - Configure environment variables for the database connection.
    - Run the migrations (*only migrations or migrations with seeders)* by accessing the following path:
        - https://api.hotel.domain.dev/commands/php-artisan-migrate
        - https://api.hotel.domain.dev/commands/php-artisan-migrate-seed

    - Setting up Laravel Sanctum
        ``` bash
        SANCTUM_STATEFUL_DOMAINS=hotel.domain.dev,api.hotel.domain.dev
        SESSION_DOMAIN=hotel.domain.dev
        ```

### SUMMARY
API in charge of serving the Hotel administration data, you can consume the API and see your [Documentation](https://documenter.getpostman.com/view/15269471/TzCS4kXs "See docs").

This API is responsible for serving all the data for the operation of the [Frontend](https://hotel.juanjosepau.dev "See demo frontend") of the application.


Screenshots
> API home page
![screenshots1](public/screenshots/api-hotel.png)

> API documentation
![screenshots1](public/screenshots/api-hotel2.png)
