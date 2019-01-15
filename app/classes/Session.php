<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 16:30
 */

namespace App\classes;


class Session
{
    /**
     * create a session
     * @param $name
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function add($name, $value)
    {
        if($name != '' && !empty($name) && $value != '' && !empty($value)){
            return $_SESSION[$name] = $value;
        }

        throw new \Exception('Name and Value required');
    }

    /**
     * get value from session
     * @param $name
     * @return mixed
     */

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Check if session exists
     * @param $name
     * @return bool
     * @throws \Exception
     */
    public static function has($name)
    {
        if($name != '' && !empty($name)){

            return (isset($_SESSION[$name])) ? true : false;
        }

        throw new \Exception('Name is required');

    }

    /**
     * remove session
     * @param $name
     * @throws \Exception
     */
    public static function remove($name)
    {
        if(self::has($name)){
            unset($_SESSION[$name]);
        }
    }

    /**
     * @param $name
     * @param $value
     * @return mixed|null
     * @throws \Exception
     */
    public static function flash($name, $value=null)
    {

        if(self::has($name)){
            $old_name = self::get($name);

            self::remove($name);

            return $old_name;
        }else{
            self::add($name, $value);
        }

        return null;
    }

}