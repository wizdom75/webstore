<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 04/04/2018
 * Time: 22:30
 */

namespace App\classes;

use Illuminate\Database\Capsule\Manager as Capsule;

class ValidateRequest
{

    private static $error = [];
    private static $error_messages = [
        'string' => 'The :attribute field cannot contain numbers',
        'required' => 'The :attribute field is required',
        'minLength' => 'The :attribute field must be a minimum of :policy characters',
        'maxLength' => 'The :attribute field must be a maximum of :policy characters',
        'mixed' => 'The :attribute field can contain letters, numbers, dash and space only',
        'number' => 'The :attribute field cannot contain any letters',
        'email' => 'Email address is not valid',
        'unique' => 'That :attribute is already taken, please try another one',
        'match' => 'Your passwords must be the same.'
    ];

    /**
     * @param array $dataAndValues, column and data to validate
     * @param array $policies
     */
    public function abide(array $dataAndValues, array $policies)
    {
        foreach ($dataAndValues as $column => $value){
            if(in_array($column, array_keys($policies))){
                self::doValidation(
                    ['column' => $column, 'value' => $value, 'policies' => $policies[$column]]
                );
            }
        }

    }

    /**
     * Perform validation on the data provided and set error messages
     * @param array $data
     */
    private static function doValidation(array $data)
    {
        $column = $data['column'];

        foreach($data['policies'] as $rule => $policy){
            $valid = call_user_func_array([self::class, $rule], [$column, $data['value'], $policy]);

            if(!$valid){
                self::setError(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$column, $policy, ' '],
                        self::$error_messages[$rule]), $column
                );
            }
    }
    }

    /**
     * @param $column, field name or column
     * @param $value, value passed into form
     * @param $policy,
     * @return bool
     */
    protected static function unique($column, $value, $policy)
    {
        if($value != NULL && !empty(trim($value))){
            return !Capsule::table($policy)->where($column, '=', $value)->exists();
        }
        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function required($column, $value, $policy)
    {
        return $value !== null && !empty(trim($value));
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function minLength($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){
            return strlen($value) >= $policy;
        }
        return true;
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function maxLength($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){
            return strlen($value) <= $policy;
        }
        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function email($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
        return true;
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function mixed($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){

            if(!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)){
                return false;
            }

        }
        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function string($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){

            if(!preg_match('/^[A-Za-z ]+$/', $value)){
                return false;
            }

        }
        return true;
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function numbers($column, $value, $policy)
    {
        if($value !== null && !empty(trim($value))){

            if(!preg_match('/^[0-9.]+$/', $value)){
                return false;
            }

        }
        return true;
    }


    /**
     * Set specific error
     * @param $error
     * @param null $key
     */
    private static function setError($error, $key = NULL)
    {
        if($key){
            self::$error[$key][] = $error;
        }else{
            self::$error[] = $error;
        }
    }

    /**
     * Return true if error found
     * @return bool
     */
    public function hasError()
    {
        return count(self::$error) > 0 ? true : false;
    }

    /**
     * Return all validation errors
     * @return array
     */
    public function getErrorMessages()
    {
        return self::$error;
    }
}