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

class Setting extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['address', 'telephone'];
    protected $dates = ['deleted_at'];


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $settings = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($settings, [
                'id' => $item->id,
                'telephone' => $item->telephone,
                'address' => $item->address,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $settings;
    }
}