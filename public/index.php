<?php

/*
|--------------------------------------------------------------------------
| APPLICATION ENVIRONMENT
|--------------------------------------------------------------------------
|
| Usage is :
|
|     development
|     testing
|     production
|
| NOTE: If you change these, also change the error_reporting() code below
| and database configuration into app/config/config.php
|
*/
define('ENVIRONMENT', 'production');

/*
|--------------------------------------------------------------------------
| ERROR REPORTING
|--------------------------------------------------------------------------
|
| Different environments will require different levels of error reporting.
| By default development will show errors but testing and live will hide them.
|
*/
if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
		error_reporting(E_ALL);
		break;

		case 'testing':
		case 'production':
		error_reporting(0);
		break;

		default:
		exit('The application environment is not set correctly in public/index.php');
	}
}

/*
|--------------------------------------------------------------------------
| Require bootstrap file
|--------------------------------------------------------------------------
|
| Init PhalconPHP and illuminate your development.
|
*/
require('bootstrap.php');

?>
