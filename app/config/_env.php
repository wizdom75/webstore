<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 28/03/2018
 * Time: 22:23
 */

define('BASE_PATH', realpath(__DIR__.'/../../'));

require_once __DIR__.'/../../vendor/autoload.php';

$dot_env = new \Dotenv\Dotenv(BASE_PATH);

$dot_env->load();


require_once __DIR__.'/_stripe.php';