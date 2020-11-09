# Appeals
Install the dependencies.

```sh
$ cd midone_admin
$ composer install
$ npm install
```


### For run migrations...


create .env file by .env.example


```sh
$ php artisan migrate
$ php artisan db:seed --class="SettingsSeeder"
$ php artisan db:seed --class="CountriesSeeder"
$ php artisan db:seed --class="PermissionsSeeder"
```

# Run Application
```sh
$ npm run watch
$ php artisan serve
```