# 🍎🥕 Fruits and Vegetables

* On `main` branch CQRS pattern
* On `service` branch Service Layer pattern
## Set up and run project (tested with Composer version 2.4.4 and docker desktop 4.28.0)
* Clone project
```bash
git clone https://github.com/MaxEpam2015/fruits-and-vegetables.git
```
* 🏃‍♂️ Running containers
```bash
docker-compose up -d
```
* Interact With database Container
```bash
docker exec -ti database bash
```
* Connect to a PostgreSQL Database Server
```bash
psql -h localhost -U postgres
```
* CREATE test DATABASE
```bash
CREATE DATABASE groceries_test;
```
* Interact With php-fpm Container
```bash
docker exec -ti php-fpm bash
```
* Run migration
```bash
php bin/console doctrine:migrations:migrate
```
* Run migration on test env
```bash
php bin/console doctrine:migrations:migrate --env=test
```
* Run tests
```bash
php bin/phpunit
```
* Parse request.json
```bash
php bin/console file:parse
```
* Open in browser
http://127.0.0.1:8082

