<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\classes\Request;
use App\models\Product;
use App\models\SubCategory;

class CategoryController extends BaseController
{

    /**
     * @throws \Exception
     */
    public  function show($slug)
    {
        $token = CSRFToken::_token();
        $slug = getIdOfSlug($slug, 'categories');

        $subcategories = SubCategory::where('category_id', $slug->id)->get();

        return view('category', compact('token', 'subcategories','slug'));
    }

    /**
     * @param $slug
     */
    public function getSubCategories($slug)
    {

        $slug = getIdOfSlug($slug, 'categories');

        $subcategories = SubCategory::where('category_id', $slug->id)->get();


        echo json_encode(['subcategories' => $subcategories]);
    }

    /**
     *
     */
    public function getProducts($slug)
    {

        $slug = getIdOfSlug($slug, 'categories');

        $products = Product::where('category_id', $slug->id)->skip(0)->take(12)->get();

        echo json_encode(['products' => $products, 'count' => count($products)]);
    }

    /**
     * @throws \Exception
     */
    public function loadMoreProducts($slug)
    {

        $request = Request::get('post');
        $slug = getIdOfSlug($slug, 'categories');
        if(CSRFToken::verifyCRFToken($request->token, false)){

            $count = $request->count;

            $item_per_page = $count + $request->next;

            $products = Product::where('category_id', $slug->id)->skip(0)->take($item_per_page)->get();

            echo json_encode(['products' => $products, 'count' => count($products)] );

        }
    }
}