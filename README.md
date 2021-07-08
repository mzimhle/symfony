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
After making sure the database connection is fine, we will create the following:
- Controller - To process form data as well as define pages
- Entity - To hanndle the database information for our table
- Form - To handle submission of member for adding and editing.
- Datatables - To display member list on the landing page

```sh
> ./bin/console make:controller
> ./bin/console make:entity
> ./bin/console make:form
> composer require omines/datatables-bundle
```
NOTE:
- All validation will be handled by the DTO which we will create under /src/DTO/MemberDTO.php
- No validation on entity and form
- allowEmptyString set to false means that empty strings are NOT considered valid, used only if there is a min in your strin validation.