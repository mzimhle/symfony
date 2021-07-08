# Symfony Configuration Website
This website will focus on creating a simple symfony website that has only two tables:
- members
- address

All we want to do is allow CRUD actions for this website also while using the following technologies
- Composer (https://getcomposer.org/download/)
- PHP 7.3.*
- Symfony (https://symfony.com/download)

Our application folder structure is:
```sh
/symfony.loc
	/logs
	/www
```
The /www folder is where my application will be stored, the /logs is where php error and access logs will be saved, this is setup on the apache vhost file.

## Install
Here we will show how all the utilities used were install, remember, this is a clean installation.
```sh
> composer create-project symfony/website-skeleton www
> composer require symfony/apache-pack
> php bin/console cache:clear
```
Run the application:
```sh
> php -S 127.0.0.1:8000 -t public
```
The above simply allows you to run the application using the following url: http://127.0.0.1:8000/. 
```sh
> symfony server:start -d
```
If you have symfony installed, you can simply run the second command above.

## Create landing page

Before coding and connecting to the database, make sure you have the database connection correct, orm has already been installed, so you just need to go to the ./env file:
```sh
###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony?serverVersion=5.7"
###< doctrine/doctrine-bundle ###
```
This is where we start with the coding. We need to create a landing page with a list of members and the ability to add and or update them.
So we need to create a Home page controller and an entity for members with its templates. It will be called HomeController.php, simply follow the prompts.

```sh
> ./bin/console make:controller
> ./bin/console make:entity
> composer require omines/datatables-bundle
```
After adding the controller, we simply sintall the datatables package.