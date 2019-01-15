<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 30/03/2018
 * Time: 21:45
 */

namespace App;

use AltoRouter;

class RouteDispatcher
{
    protected $match;
    protected $controller;
    protected $method;

    public function __construct(AltoRouter $router)
    {
        $this->match = $router->match();

        if($this->match){

            list($controller, $method) = explode('@', $this->match['target']);

            $this->controller = $controller;
            $this->method = $method;

            if (is_callable(array(new $this->controller, $this->method))){

                call_user_func_array(array(new $this->controller, $this->method), array($this->match['params']));

            }else{

                echo "This method {$this->method} is not defined in the controller {$this->controller} ";
            }

        }else{
            header($_SERVER['SERVER_PROTOCOL'].'404 Not found');

            view('errors/404');

        }
    }

}