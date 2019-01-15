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

class Message extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['sender_name', 'sender_email', 'message'];
    protected $dates = ['deleted_at'];

    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $messages = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($messages, [
                'id' => $item->id,
                'sender_name' => $item->sender_name,
                'sender_email' => $item->sender_email,
                'message_read' => $item->message_read,
                'message' => $item->message,
                'created_at' => $item->created_at,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $messages;
    }
}