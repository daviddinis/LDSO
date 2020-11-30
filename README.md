# T1G3 - Gestão de Frota Automóvel / Automotive Fleet Management

## Description
In a company with a large fleet of cars, it is difficult to manage the daily use of the vehicles, control the costs associated with each vehicle, register curative maintenance and create periodic maintenance planning. This project aims to integrate cost control (such as budget comparison) in a single platform, history of services performed, maintenance and inspection alerts, management and assignment of vehicles to employees for occasional trips, possibility of integration with an OBD2 interface allowing GPS location, sending, management and error monitoring of each vehicle. The platform should be able to send notifications for emails and generate internal alerts for various types of notices.


## Wiki
More information about the project can be found on our [WIKI](https://gitlab.com/feup-tbs/ldso2021/t1g3/-/wikis/)

### Quick links
* [What's new](https://gitlab.com/feup-tbs/ldso2021/t1g3/-/wikis/What's-new)
* [Project setup](Setup)
* [Coding Guidelines](https://gitlab.com/feup-tbs/ldso2021/t1g3/-/wikis/Coding-Guidelines)
* [Security Vulnerabilities](https://gitlab.com/feup-tbs/ldso2021/t1g3/-/wikis/Security-Vulnerabilities)
* [Architecture](https://gitlab.com/feup-tbs/ldso2021/t1g3/-/wikis/Architecture)


## Setup
The project uses [Laravel](https://laravel.com/) as the development framework with a postgresql database. To setup, install and deploy it we've created a short wiki with information on the required steps.

For convenience the project has been dockerized and the main docker-compose file can be found under `./fleetmanagement`. 

To setup, build and run the project please open a terminal and follow these steps:

- `cd fleetmanagement`
- `docker-compose build && docker-compose up -d`

Verify the app is running using `docker ps` and make sure all 4 containers are up (`postgres`, `pgadmin4`, `laravelapp`, `selenium`)

Next you need to open up a CLI towards the Laravel container and run some commands. You can either use the Docker GUI directly but you can also run the commands directly against the container using a terminal like this `docker-compose exec app bash -c "..."` 

The commands you need to run are:
```php
 composer install
 php artisan config:cache // not strictly needed but always a good idea to clear cache
 php artisan db:seed
 php artisan serve
```
The project should now start. You can access the webapp on `localhost:8888` and pgadmin on `localhost:5050`

## Tests
Tests are located under `fleetmanagement/tests`. Currently there are unit tests in the `tests/Unit` folder and automated browser tests in the `tests/Browser` folder. You can run them by opening a CLI towards the container `app` and running the command 

```php
// IMPORTANT! Before running tests you must manually reset the DB and populate it with test data using
docker-compose exec app bash -c "php artisan db:seed"

// To run the whole test suite
docker-compose exec app bash -c "vendor/bin/phpunit --process-isolation ./test"

// To run only unit tests
docker-compose exec app bash -c "php artisan test"

// To run only dusk browser tests
docker-compose exec app bash -c "php artisan dusk --process-isolation"

```
## Members

### Product Owner

* Marco Sousa, Memória Visual (msousa@memoriavisual.pt)

### Development Team

* André Mori (up201700493@fe.up.pt)

* David Dinis - Surrogate PO (up201706766@fe.up.pt)

* Gustavo Tavares (up201700129@fe.up.pt)

* Luís Oliveira (up201707229@fe.up.pt)

* Maria Caldeira (up201704507@fe.up.pt)

* Pedro Alves (up201707234@fe.up.pt)

* Ricardo Pereira (ei01020@fe.up.pt)

* William Hjelm - Scrum Master (up202001854@fe.up.pt)