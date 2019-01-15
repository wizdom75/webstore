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

class Order extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['user_id', 'order_no', 'product_id', 'quantity', 'unit_price', 'status', 'total'];
    protected $dates = ['deleted_at'];


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $orders = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($orders, [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'unit_price' => $item->unit_price,
                'quantity' => $item->quantity,
                'total' => $item->total,
                'status' => $item->status,
                'order_no' => $item->order_no,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $orders;
    }
}