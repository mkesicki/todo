#Install

 - Clone repository
 ```git clone https://github.com/mkesicki/todo.git```

 - Run composer install in repository folder
 ```composer install```

- Create and configure .env file with database name and permissions

- Migrate database
```php artisan migrate```

- Optionally insert test data
```mysql -uUser -pPassword DatabaseName < schema.sql```

- Start local server
```php -S localhost:8000 -t public```

- To run tests
```vendor\bin\phpunit``` 