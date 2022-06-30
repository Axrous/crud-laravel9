
# CRUD LARAVEL

Simple RESTful API CRUD.

Features :

- Create User
- Get All User
- Get User By Id
- Update User
- Delete User

## Clone

1. Clone

```bash
-git clone https://github.com/Axrous/crud-laravel9.git
-cd crud-laravel9
```

2. Install composer
```bash
composer install
```

3. Configure Database & Generate Key

Create database with name `crud_laravel`.

then copy `.env.example` file with

```bash
cp .env.example .env
```

then, go to `.env` change the `DB_DATABASE` with `crud_laravel`

Generate key with command
```bash
php artisan key:generate
```

4. Migration

```bash
php artisan migrate:fresh
```

5. Run laravel
```bash
php artisan serve
```