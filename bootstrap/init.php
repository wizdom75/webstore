<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 28/03/2018
 * Time: 22:30
 */

/**
 * Start session if not already started
 */

if(!isset($_SESSION)) session_start();


/**
 * load environment variables
 */
require_once __DIR__.'/../app/config/_env.php';

/**
 * Instantiate database
 */
new \App\Classes\Database;


/**
 * Set custom error handler
 */
set_error_handler([new \App\classes\ErrorHandler(), 'handleErrors']);


/**
 * load routes function
 */
require_once __DIR__.'/../app/routing/routes.php';


/**
 * Instantiate RouteDispatcher
 */
new \App\RouteDispatcher($router);

