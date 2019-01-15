<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 28/03/2018
 * Time: 22:05
 */

require_once __DIR__ . '/../bootstrap/init.php';

$app_name = getenv('APP_NAME');

use Illuminate\Database\Capsule\Manager as Capsule;

$user = Capsule::table('categories')->get();

//var_dump($user->toArray());

