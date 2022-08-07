## Vizualtech test

Swagger link:
[https://aniqdev.github.io/visualtech/swagger/](https://aniqdev.github.io/visualtech/swagger/)

To run application
```sh
git clone https://github.com/aniqdev/laravel-vizualtech.git
cd laravel-vizualtech/
composer install
npm install
npm run build
php artisan migrate --seed
php artisan serve
```
then go to [http://127.0.0.1:8000/](http://127.0.0.1:8000/)