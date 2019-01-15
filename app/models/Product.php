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

class Product extends Eloquent
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['name', 'price', 'description', 'category_id', 'sub_category_id', 'image_path', 'quantity'];
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }


    /**
     * @param $data
     * @return array
     */
    public function transform($data)
    {
        $products = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($products, [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'description' => $item->description,
                'category_id' => $item->category_id,
                'category_name' => Category::where('id', $item->category_id)->first()->name,
                'sub_category_id' => $item->sub_category_id,
                'sub_category_name' => SubCategory::where('id', $item->sub_category_id)->first()->name,
                'image_path' => $item->image_path,
                'quantity' => $item->quantity,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $products;
    }
}