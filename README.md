## run commands 

> composer install

> sudo docker-compose build app

copy env.example to .env

> sudo docker-compose up -d

> php artisan key:generate

> sudo docker-compose exec db2 bash

> mysql
>
>>CREATE DATABASE IF NOT EXISTS laravel;
>
>>CREATE USER 'mane2'@'localhost' IDENTIFIED BY 'pass2';
>
>>GRANT ALL PRIVILEGES ON laravel.* TO 'mane2'@'localhost' with grant option;
>
>>FLUSH PRIVILEGES;

### exit from mysql

### exit from docker

update DB_PORT=3306 in .env to DB_PORT=3308
run from local
> env DB_HOST=127.0.0.1 php artisan migrate:refresh --seed
>
>env DB_HOST=127.0.0.1 php artisan voyager:admin your@email.com --create

update DB_PORT=3308 in .env to DB_PORT=3306

[http://localhost:9002/admin/login](http://localhost:9002/admin/login)

user: your@email.com
password: password

setup in .env please get from app
docker network inspect bridge
API_HOST


[http://127.0.0.1:9002/admin/customer](http://127.0.0.1:9002/admin/customer)
