# ROOKIE  is a PHP very lightweight framework for rookie developers (2Mo)
- Server: PHP, MySQL
- Client: Html, CSS, Bootstrap, Javascript, JQuery Ajax.
- HTTP server responses: html or Json.


## Public project
- Author : Cyril VASSALLO
- Project: 2021

# What is Rookie PHP ? 

## Made for Learning
Rookie has been build for new developer that are learning PHP.
- It's made from scratch to help developer to understand web application client/server.
- It's an ultra lightweight framework.
- It's a low level PHP code, except Twig no imbedded dependencies are required. We attached that developers can well understand what's basically happened under woods in a framework. 
- It's a very flexible architecture with 3 backend layers (Controller, Service, database...);
- It's adaptive and scalable

## What will you discover ?
- You will discover basic knowledge on web application.
- That not a full featured architecture but you will learn essential.
- You can improve the structure and feature by yourself.
- It's flexible you can redo the structure almost as you want, thanks to PATH constants loaded at the beginning of the script
- A proposal of file and folder architecture from scratch
- Route the application (a solution among other...)
- Basic request POST and GET data security filter and usage
- Controllers layer with a control of actions on server
- Services layer for data access
- Namespace usage
- Object instance and object life cycle management
- Database initialization and installation 
- SQL components
- Add and Use dependencies with composer
- Use case of template Engine
- An all CRUD example provided as model
- Html to Json switching
- Manage twig templates with Html, CSS and Bootstrap.
- Javascript and JQuery AJax in a frontend usage
- Redo the complete page Actors CRUD using the Movies example 



# Quick overview of the full Structure

Rookie-Project // Your root clone folder 
- config
	- config_dev.ini
	- config_prod.ini
	- db_init_script.sql
	- routes.ini
- Rookie
	- DataComponents
		- Database.php
		- Initialize.php
	- HttpComponents
		- jsonResponse.php
		- Request.php
	- Kernel
		- Configuration.php
		- Router.php
	- Legacy
	- TemplateEngine
- public
	- assets
		- images
			- Rookie.jpg
		- svg
			- logo.svg
	- css
		- library
			- bootstrap
				- bootstrap.min.css
			- dataTables
				- dataTables.bootstrap4.min.css
				- dataTables.min.css
		- src
			- footer.css
			- global.css
			- home.css
			- movie.css
	- js
		- library
			- bootstrap
				- bootstrap.min.js
			- dataTables
				- dataTables.bootstrap4.min.js
				- dataTables.min.js
				- jquery.dataTables.min.js
			- jquery
				- jquery.min.js
		- src
			- footer.css
			- global.css
			- home.css
			- movie.css
	- index.php // entry point
- src
	- Controllers
		- HomeController.php
		- MoviesController.php
	- Services
		- MoviesServices.php
	- SQL
		- actors
		- movies
			- delete_movie.sql
			- insert_movie.sql
			- select_movies.sql
			- select_movie.sql
			- update_movie.sql
	- templates
		- home
			- home.html.twig
		- movies
			- movies.html.twig
		- actors
		- partials
			footer.html.twig
			navbar.html.twig
		- base.html.twig
- vendor // Not include - You need to install composer and run composer install
- .env
- .gitignore
- .htaccess
- composer.json
- composer.lock
- README.md
