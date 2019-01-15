<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 18:15
 */

namespace App\classes;


class Redirect
{
    /**
     * Redirect to a specific page
     * @param $page
     */
    public static function to($page)
    {
        header("location: $page");
    }


    /**
     * Redirect to same page
     */
    public static function back()
    {
        $uri = $_SERVER['uri'];

        header("location: $uri");
    }
}