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

class Category extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['name', 'slug'];
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $categories = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($categories, [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $categories;
    }
}