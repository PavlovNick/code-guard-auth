<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Project

This project is a WebApi framework written on php Laravel framework, 
where functionality for authorization and verification 
(sign in, sign up, refresh token, send verification, verify account, password reset, logout) 
is implemented not through links, but through 4-digit codes with sending to mail.

## Project deployment

Follow these steps to successfully deploy the project on your local computer.

### 1. Cloning a project

To get started, clone the project from the GitHub repository. Open a terminal and run the following command:

```bash
git clone https://github.com/PavlovNick/code-guard-auth.git
```

### 2. Creating the database

Create a database using MySQL. Use utf8mb4_general_ci encoding when creating the database

### 3. Installing dependencies

Go to the root project folder and run the following command to install all dependencies through Composer:

```bash
composer install
```

### 4. Configuration of the .env file

Create an .env file in the project root folder based on the .env.example file. Fill in your settings for database connection and other parameters.

#### 4.1. Configure the database connection
```php
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
#### 4.2. Set up a connection to the mail server

> **Note:** To test sending notifications to mail, you can use [Mailtrap](https://mailtrap.io/) mail server.

```php
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="laravel@app.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Application key generation

Execute the command to generate an application key:

```bash
php artisan key:generate
```

### 6. Execution of migrations

Apply basic migrations to create tables in the database, combined with the option to populate the database with starting data :

```bash
php artisan migrate --seed
```

### 7. Authorization server setup

After filling the database, you will need to install encryption keys for the authorization server (OAuth2), which is implemented using the Laravel Passport package.
In addition, the command will create the "personal access" and "password provisioning" clients that will be used to generate the access tokens.

Execute the command to generate the encryption keys needed to create secure access tokens:

```bash
php artisan passport:install
```

After executing this command, something like this will appear in the console:

```bash
Personal access client created successfully.
Client ID: 1                                           
Client secret: your_encryption_key
Password grant client created successfully.            
Client ID: 2
Client secret: your_encryption_key
```

Your secret encryption key for password grant client must be written to the .env file

```php
PASSPORT_GRANT_PASSWORD_CLIENT_ID=2
PASSPORT_GRANT_PASSWORD_CLIENT_SECRET=your_encryption_key
```

After that, run the command that will re-calculate and cache your already updated configurations:

```bash
php artisan optimize
```

### 8. Starting a local server

Start the local server for development:

```bash
php artisan serve
```

