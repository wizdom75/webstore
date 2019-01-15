<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 31/03/2018
 * Time: 21:54
 */

namespace App\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{

    public function __construct()
    {
        $db = new Capsule;

        $db->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'
        ]);

        $db->setAsGlobal();
        $db->bootEloquent();
    }

}