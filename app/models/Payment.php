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

class Payment extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['user_id', 'order_no', 'amount', 'status'];
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
                'user_id' => $item->user_id,
                'order_no' => $item->order_no,
                'amount' => $item->amount,
                'status' => $item->status,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $users;
    }
}