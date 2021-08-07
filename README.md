## Tasker (MVC application on PHP without frameworks)

## Installation

```bash
composer install
```

Copy .env from .env.example file and then write your database config 

```bash
cp .env.example .env
```

Run migrations

```bash
php database/migrations/migrations.php
```

Run user seeder

```bash
php database/seeders/seeders.php
```

Run:

```bash
cd public/
php -S localhost:8000
```
Enter in browser:

```bash 
localhost:8000
```




