<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\classes\Request;
use App\models\Product;
use App\models\SubCategory;
use App\models\Category;


class SubCategoryController extends BaseController
{

    /**
     * @throws \Exception
     */
    public  function show($slug)
    {
        $token = CSRFToken::_token();
        $slug = getIdOfSlug($slug, 'sub_categories');


        $subcategory = SubCategory::where('id', $slug->id)->first();
        $category = Category::where('id', $slug->category_id)->first();

        $subcategories = SubCategory::where('category_id', $slug->category_id)->get();


        return view('sub_category', compact('token', 'subcategory', 'category', 'slug', 'subcategories'));
    }

    /**
     * @param $slug
     */
    public function getCategory($slug)
    {

        $slug = getIdOfSlug($slug, 'categories');

        $category = Category::where('category_id', $slug->id)->get();


        echo json_encode(['categories' => $category]);
    }

    /**
     *
     */
    public function getProducts($slug)
    {

        $slug = getIdOfSlug($slug, 'sub_categories');

        $products = Product::where('sub_category_id', $slug->id)->skip(0)->take(8)->get();

        echo json_encode(['products' => $products, 'count' => count($products)]);
    }

    /**
     * @throws \Exception
     */
    public function loadMoreProducts($slug)
    {

        $request = Request::get('post');
        $slug = getIdOfSlug($slug, 'sub_categories');
        if(CSRFToken::verifyCRFToken($request->token, false)){

            $count = $request->count;

            $item_per_page = $count + $request->next;

            $products = Product::where('sub_category_id', $slug->id)->skip(0)->take($item_per_page)->get();

            echo json_encode(['products' => $products, 'count' => count($products)] );

        }
    }
}