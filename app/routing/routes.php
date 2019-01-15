<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 29/03/2018
 * Time: 00:08
 */

$router = new AltoRouter;



$router->map('GET', '/', 'App\Controllers\IndexController@show', 'home');

$router->map('GET', '/featured', 'App\Controllers\IndexController@featuredProducts', 'featured_product');

$router->map('GET', '/get-products', 'App\Controllers\IndexController@getProducts', 'get_product');

$router->map('GET', '/get-banners', 'App\Controllers\IndexController@getBanners', 'get_banners');

$router->map('GET', '/get-blurb', 'App\Controllers\IndexController@getBlurb', 'get_blurb');

$router->map('POST', '/load-more', 'App\Controllers\IndexController@loadMoreProducts', 'load_more_product');



$router->map('GET', '/product/[i:id]', 'App\Controllers\ProductController@show', 'product');

$router->map('GET', '/product-details/[i:id]', 'App\Controllers\ProductController@get', 'product_details');



$router->map('GET', '/category/[*:slug]', 'App\Controllers\CategoryController@show', 'category');

$router->map('GET', '/subcategory/[*:slug]', 'App\Controllers\SubCategoryController@show', 'subcategory');

$router->map('GET', '/get-subcategory/[*:slug]', 'App\controllers\CategoryController@getSubCategories', 'get_subcategory');

$router->map('GET', '/get-category-products/[*:slug]', 'App\Controllers\CategoryController@getProducts', 'get_category_product');

$router->map('POST', '/load-more-category-products/[*:slug]', 'App\Controllers\CategoryController@loadMoreProducts', 'load_more_category_product');

$router->map('GET', '/get-subcategory-products/[*:slug]', 'App\Controllers\SubCategoryController@getProducts', 'get_subcategory_product');

$router->map('POST', '/load-more-subcategory-products/[*:slug]', 'App\Controllers\SubCategoryController@loadMoreProducts', 'load_more_subcategory_product');


$router->map('POST', '/message', 'App\controllers\MessageController@create', 'send_product_quote');

$router->map('GET', '/page/[*:slug]', 'App\controllers\PageController@show', 'show_page');
$router->map('GET', '/page-details/[*:slug]', 'App\controllers\PageController@showDetails', 'show_page_details');

require_once __DIR__."/admin_routes.php";
require_once __DIR__."/auth_routes.php";
require_once __DIR__."/cart_routes.php";