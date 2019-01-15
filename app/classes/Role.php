<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 08/05/2018
 * Time: 22:03
 */

namespace App\classes;

class Role
{
    public static function middleware($role)
    {
        $message = '';
        switch ($role){
            case 'admin':
                $message = 'You are not authorised to view the Admin panel.';
                break;
            case 'user':
                $message = 'You are not authorised to view this page.';
                break;
        }

        if(isAuthenticated()){
            if(\user()->role != $role){
                Session::add('error', $message);
                return false;
            }
        }else{

            Session::add('error', $message);
            return false;
        }
        return true;
    }
}