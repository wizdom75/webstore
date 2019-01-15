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

class SubCategory extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['name', 'slug', 'category_id'];
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany(Category::class);
    }


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $subcategories = [];

        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($subcategories, [
                'id' => $item->id,
                'category_id' => $item->category_id,
                'name' => $item->name,
                'slug' => $item->slug,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $subcategories;
    }
}