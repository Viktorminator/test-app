# Test task User-Company API

## Installation

```
composer install &&
php artisan migrate &&
php artisan db:seed &&
php artisan swagger-lume:generate
```

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
