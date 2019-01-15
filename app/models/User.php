<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 22:21
 */

namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['username', 'fullname', 'email', 'password', 'address', 'role'];
    protected $dates = ['deleted_at'];

    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $users = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($users, [
                'id' => $item->id,
                'username' => $item->username,
                'fullname' => $item->fullname,
                'email' => $item->email,
                'address' => $item->address,
                'role' => $item->role,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $users;
    }

}