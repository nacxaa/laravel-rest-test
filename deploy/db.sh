echo "create database laravelrest" | mysql -h laravel-rest-test_mysql_1 -ptest123
php artisan migrate
php artisan db:seed