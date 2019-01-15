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

class Page extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['title', 'body'];
    protected $dates = ['deleted_at'];


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $pages = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($pages, [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'body' => $item->body,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $pages;
    }
}