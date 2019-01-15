<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\classes\Request;
use App\models\Product;
use App\models\Banner;
use App\models\Page;

class IndexController extends BaseController
{

    public  function show()
    {
        $token = CSRFToken::_token();
        return view('home', compact('token'));
    }

    public function featuredProducts()
    {
        $products = Product::where('featured', 1)->inRandomOrder()->limit(4)->get();

        echo json_encode(['featured' => $products]);
    }

    public function getProducts()
    {
        $products = Product::where('featured', 0)->skip(0)->take(8)->get();

        echo json_encode(['products' => $products, 'count' => count($products)]);
    }

    public function getBanners()
    {
        $banners = Banner::where('active', 1)->get();

        echo json_encode(['banners' => $banners, 'count' => count($banners)]);
    }

    public function getBlurb()
    {
        $blurb = Page::where('slug','home')->first();

        $blurb['body'] = nl2br($blurb['body']);

        echo json_encode(['blurb' => $blurb, 'count' => count($blurb)]);
    }

    public function loadMoreProducts()
    {
        $request = Request::get('post');
        if(CSRFToken::verifyCRFToken($request->token, false)){

            $count = $request->count;

            $item_per_page = $count + $request->next;

            $products = Product::where('featured', 0)->skip(0)->take($item_per_page)->get();

            echo json_encode(['products' => $products, 'count' => count($products)]);

        }
    }
}