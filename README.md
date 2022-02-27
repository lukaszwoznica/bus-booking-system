# :oncoming_bus: Bus Booking System

[![Live Demo](https://img.shields.io/badge/demo-online-success?logo=heroku)](#live-demo)
[![Current Version](https://img.shields.io/github/v/tag/lukaszwoznica/bus-booking-system?label=version)](https://github.com/lukaszwoznica/bus-booking-system/tags)

## Overview

Bus seat booking system created with Laravel 7.

## Table of Contents

* [Main Technologies](#main-technologies)
* [Features](#features)
* [Installation](#installation)
* [Environment Configuration](#environment-configuration)
    * [Database](#database---mysql)
    * [Queue connection - Redis](#queue-connection---redis)
    * [Email service](#email-service)
* [Live Demo](#live-demo)

## Main Technologies

* Laravel 7
* Blade templates
* Vue.js 2
* Bootstrap 4
* Sass (SCSS)
* MySQL
* Redis

## Features

* Responsive design.
* User authentication:
    * Register and login.
    * Email verification.
    * Reset forgotten password.
* Edit user profile.
* User roles (Super Admin, Admin and User).
* Search for bus rides between two locations on a specific date.
* Book seats for a specific bus ride if available.
* Email notifications about the change of booking status.
* The booking can be cancelled up to two hours before departure.
* Admin panel:
    * Dashboard with charts and stats.
    * CRUD for buses, locations, routes, rides and users (complete users CRUD available only with super admin
      permissions).
    * DataTables integration (instant search, column ordering, pagination etc.).
    * Bus rides can be single (on a specific date) or cyclic (according to a set schedule).
    * Bookings management.
    * Manual and automatic booking confirmations.

## Installation

### Prerequisites

To correctly configure the application, you need to prepare all the following requirements on your development machine:

* PHP 7.4 and Composer
* Node.js 12 and npm
* MySQL 8 database
* Redis database (optional if you intend to use the `sync` queue driver)

### Setup

1. Clone the repository and open the project directory.

```bash
git clone git@github.com:lukaszwoznica/bus-booking-system.git && cd bus-booking-system
```

2. Install Composer dependencies.

```bash
composer install
```

3. Create an environment configuration file and set required variables (see
   the [Environment Configuration section](#environment-configuration) for a description of how to configure your
   environment variables).

```bash
cp .env.example .env
```

4. Generate Laravel application key.

```bash
php artisan key:generate
```

5. Install Node.js dependencies and compile frontend assets.

```bash
npm install
```

6. Run database migrations and populate the database with some dummy data.

```bash
php artisan migrate:fresh --seed
```

7. Run Redis queue worker (if you are using `redis` queue driver).

```bash
php artisan queue:work redis
```

8. Start Laravel's local development server.

```bash
php artisan serve
```

9. At this point, the application should be ready to go at http://localhost:8000/.

## Environment Configuration

This section describes how to configure environment variables in the .env file.
For more detailed information [see the official Laravel documentation](https://laravel.com/docs/7.x).

### Database - MySQL

Although Laravel supports various database backends, MySQL is recommended for this project. The application runs some
raw SQL queries, therefore errors may arise when using a different database driver. The following environment variables
must be properly configured in the .env file.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_db
DB_USERNAME=root
DB_PASSWORD=null
```

### Queue connection - Redis

By default, Redis is set up as the queue driver. If you want to use the queuing feature for some jobs, you must
configure a connection to the Redis database by setting the variables listed below. Alternatively, you can set the queue
driver to `sync`. When using this driver, queued jobs will be executed immediately (synchronously) within the current
process.

```dotenv
QUEUE_CONNECTION=redis 

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

### Email Service

The application has several functionalities related to sending emails, so you need some service to handle them. In a
development environment, you can use a test tool such as Mailtrap or MailHog. However, if you want to send real emails,
you need to configure some email service. You can use API-based drivers such as Mailgun, Postmark, Amazon SES or any
SMTP server. The connection with chosen email service should be configured using the following variables.

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

## Live Demo

A working live demo of the Bus Booking System is available here: https://bbs-laravel.herokuapp.com.

### :information_source: Notes

* The database is automatically refreshed and populated with dummy data every two hours in this demo.

* You can create a new user account or log in using one of the following credentials:

| Role | Email | Password |
|---|---|---|
| Admin | admin@bbs.xyz | BbsAdmin123 |
| User | user@bbs.xyz | BbsUser123 |
