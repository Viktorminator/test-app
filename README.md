# Test task User-Company API

## Installation

```
cp .env.example .env
```
Add DB settings to `.env` file:
```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=lumen
DB_USERNAME=postgres
DB_PASSWORD=secret
```
Generate `API_KEY` and put it in `.env` file.
```
composer install &&
php artisan migrate &&
php artisan db:seed &&
php artisan swagger-lume:generate
```
## Test connection
http://localhost:8080/test

To add extra data use
```
php artisan db:seed UsersAndCompaniesSeeder
```
## Swagger docs

http://localhost:8080/api/documentation

## Postman

Postman API collection can be imported from `storage/postman/Yellow media.postman_collection.json`

## Test User

```json
{
    "email": "admin@mail.com",
    "api_token": "api_token",
    "email_token": "email_token"
}
```
