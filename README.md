# cofarmer

CoFarmer is a boilerplate Application that allows different types of users to manage a part of the farming process through having a managed authorities on CRUD operations for Tractors, Fields and Processes.

This part of the application is restricted to a restful Web Services layer, fully functional and documented with Swagger. but it can be considered as the first prototype as it still requires more testing and cases handling.


The Source code is available on Github:  https://github.com/yaziderman/cofarmer


To make it up and running on your machine, follow the steps:

- Check if your machine has the minimal requirments for Laravel: https://laravel.com/docs/5.8/installation#installation
- Aquire the source code, either by cloning or the Download option.
- Create a Database: Ex. cofarmer
- Copy .env.example into a new file: .env and update the connectivity settings in it, as follows:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<Database Name>
DB_USERNAME=<username>
DB_PASSWORD=<password>
```
- Install the Required dependencies.
```
composer install
```
- Generate the App Key
```
php artisan key:generate 
```
- Migrate the DB
```
php artisan migrate
```

- Generate Some Testing Data (Optional):
```
php artisan db:seed --class=DatabaseSeeder
```

- Run a local server, which is the fastest way:
```
php artisan serve
```
- If everything worked well, you will be able to access the service documentation using the link:
http://localhost:8000/api/documentation


Enjoy!
