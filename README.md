### Installation guide

Clone project

```bash
git clone git@github.com:sebastianGVL/workwize_study.git
```

Have docker installed
```bash
cd workwize_study
cp .env.example .env

DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_USERNAME=whatever
DB_PASSWORD=whatever_u_want
WWWGROUP=1000
WWWUSER=1000
PWD=""

docker-compose up -d
docker exec -it $(docker ps -q --filter "name=laravel.test") bash
composer install
php artisan migrate
```

This makes your project build without the need of local php.  
After that sail can be used for local development.
```
./vendor/bin/sail shell / up -d / ... etc
```

About project structure

This is done in a DDD manner, this way we de-coupled the modules.
Storefront is separated from Admin entirely, thats why we have a little bit of duplication.
No repositories used since this is laravel and it's quite hard to de-couple Eloquent.

Structure:  
--Module  
----Domain ( Models, interfaces )  
----Application (Services, Data, EventListeners, Observers )  
----Infrastrcture ( Migrations, Factories, Seeders )  
----Interface (GraphQL, Http, etc)  
----Providers (Not a DDD concept since it does a couple of stuff)  


