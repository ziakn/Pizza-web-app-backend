# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* This is Pizza Web App Admin Panel with Login System  (SPA)
* Version 1.0.0

### How do I get set up? ###

* The Pizza Web App Admin Panel is For onlline pizza delivery system, The Admin Can add diffrent type of categories , Ingredient, Cusines, Pizza etc and much more..
* install repositry link 
* download node module in your system
* go inside {Pizza Web App Backend} 
* open terminal and go to {Pizza Web App Backend} folder or simply open VSCODE Terminal
* npm install
* cp.env.example .env
* composer update
* php artisan key:generate
* setup database setting in env file
* php artisan migrate:refresh --seed 
* remove the old storage file from public folder
* php artisan storage:link
* php artisan serve
* npm run watch
* database is also available in repositry folder name deliverypizza.sql

### For Online Server deployement ###
* npm run production
* if you are deployin on server ,, after uploading to server go inside public folder  delete storage folder
* run www.yourdomain.com/foo

## Link ##

* url/login       
* url/dashboard

### Technology Used ###

* Laravel 7
* PHP 7
* MYSQL 
* Vuejs
* Vuetify

### Who do I talk to? ###

* ziakn03@gmail.com