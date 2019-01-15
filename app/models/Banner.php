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

class Banner extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['title', 'link_url'];
    protected $dates = ['deleted_at'];


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $banners = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($banners, [
                'id' => $item->id,
                'title' => $item->title,
                'image_url' => $item->image_url,
                'link_url' => $item->link_url,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $banners;
    }
}