# Laravel REST API test application

This is a small demonstrational application that the following endpoints:

1. create product (price, productType, color, size)

```curl -X POST http://localhost/api/product  -H "Accept: application/json"  -H "Content-Type: application/json"  -d '{"price": 10.11, "productType": "mug", "color": "white", "size": "l", "title":"Lala"}'```
This POST endpoint creates new product.

2. create order (Collection of products and quiantities)

```curl -X POST http://localhost/api/order  -H "Accept: application/json"  -H "Content-Type: application/json"  -d '{"sent":1,"items":[{"productId": 1, "quantity": 1}, {"productId": 2, "quantity": 1}],"ip":"84.245.207.16"}'```
This POST endpoint creates new order. Here 'sent' is obligatory, 'items' contains array of products IDs and their quantities, optional 'ip' imitates IP address that should be treated as visitor's IP.

3. list all Orders

```http://localhost/api/orders``` returns all orders registered in system in JSON

4. list all Orders by productType

```http://localhost/api/ordersByType/type``` returns orders that have at least one product of type 'type'. substitute 'type' with 'mug', 'boots', 't-shirt' or other used productType

## Installation
Application uses Docker for deployment. Three containers used: nginx proxy, php fpm for application, mysql for db.
1. Download, build and run. Containers should be up and running exposing default ports (80, 443, 3306) on localhost.
- git clone https://github.com/nacxaa/laravel-rest-test.git
- cd laravel-rest-test
- docker-compose build
- docker-compose up
2. Initialize database (if running for the first time) — migration and data seed.
- docker exec myapp_app_1 sh deploy/db.sh
3. Done. Use application using browser, curl or frontend framework.
