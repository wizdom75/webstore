<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 17:03
 */

namespace App\classes;


class CSRFToken
{

    /**
     * Generate token if one does not exist already
     * @return mixed
     * @throws \Exception
     */
    public static function _token()
    {


        if(!Session::has('token')){
            $randomToken = base64_encode(openssl_random_pseudo_bytes(32));

            Session::add('token', $randomToken);
        }

        return Session::get('token');

    }

    /**
     * Verify CSRF Token
     * @param $requestToken
     * @param $regenerate
     * @return bool
     * @throws \Exception
     */
    public static function verifyCRFToken($requestToken, $regenerate = true)
    {
        if(Session::has('token') && Session::get('token') === $requestToken){
            if($regenerate){
                Session::remove('token');
            }

            return true;
        }
        return false;

    }

}