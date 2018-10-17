echo "create database laravelrest" | mysql -h myapp_mysql_1 -ptest123
php artisan migrate
php artisan db:seed