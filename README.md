## Vizualtech test

Swagger links:  
[https://aniqdev.github.io/visualtech/swagger/](https://aniqdev.github.io/visualtech/swagger/)  
[https://aniqdev.github.io/visualtech/redoc/](https://aniqdev.github.io/visualtech/redoc/)  

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
then open [http://127.0.0.1:8000/](http://127.0.0.1:8000/) in browser

### implemented the following api endpoints

```
GET|HEAD        api/books ............... index
POST            api/books ............... store
GET|HEAD        api/books/{book} ........ show
PUT|PATCH       api/books/{book} ........ update
DELETE          api/books/{book} ........ destroy
```