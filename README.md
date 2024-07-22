# Laravel Base

A Laravel SaaS starter.

## Working with queues locally

Start workers
```
php artisan queue:work
```

Specify queue and sleep parameters
```
php artisan queue:work --queue=funnels --sleep=3
```

Restart workers
```
php artisan queue:restart
```

## Install Locally

**Step 1:** Clone this repository

```
git clone https://github.com/heyharmon/laravel-starter.git
```

<br>

**Step 2:** Change directory into application

```
cd 'app-name'
```

<br>

**Step 3:** Install dependencies

```
composer install
```

<br>

**Step 4:** Copy **env.example** to **.env** and setup environment
> Example database connection:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app-name
DB_USERNAME=root
DB_PASSWORD=
```

<br>

**Step 5:** Generate unique app key

```php
php artisan key:generate
```

<br>

**Step 6:** Migrate and seed database

```php
php artisan migrate --seed
```

<br>

**Step 7:** Serve application

> Using Artisan CLI, run:
```
php artisan serve
```
Then visit: http://127.0.0.1:8000


> Using Valet, run:
```
valet link app-name
```
Then visit: http://app-name.test

**Step 8:** Secure application

> Using Artisan CLI, run:
```
valet secure analytics-api
```
> Unsecure by running: valet unsecure analytics-api

## Get started

[WIP] - API usage instructions coming soon.

### Token Authentication
The Token Authentication allows you to issue API tokens / personal access tokens that may be used to authenticate API requests to your application. When making requests using API tokens, the token should be included in the Authorization header as a Bearer token. [Read More](https://laravel.com/docs/8.x/sanctum#issuing-api-tokens)

After you install, migrate and seed your database, open Tinker and generate a personal access token:
```
php artisan tinker
$user = DDD\Domain\Base\Users\User::find(1);
$user->createToken('test');
```

Use the plainTextToken returned in request header:
```
Header Key: Authorization
Header Value: Bearer YOUR_PLAINTEXT_TOKEN
```

### API Endpoints

[WIP] - API endpoints.
