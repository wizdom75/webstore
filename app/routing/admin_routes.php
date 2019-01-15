<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 29/03/2018
 * Time: 00:08
 */

/**
 * for admin routes
 */
$router->map('GET', '/admin', 'App\Controllers\Admin\DashboardController@show', 'admin_dashboard');
$router->map('GET', '/admin/charts', 'App\Controllers\Admin\DashboardController@getChartData', 'admin_dashboard_charts');
$router->map('POST', '/admin', 'App\Controllers\Admin\DashboardController@get', 'admin_form');


/**
 * Product category routes
 */
$router->map('GET', '/admin/product/categories',
    'App\Controllers\Admin\ProductCategoryController@show', 'product_category');


$router->map('POST', '/admin/product/categories',
    'App\Controllers\Admin\ProductCategoryController@create', 'create_product_category');


$router->map('POST', '/admin/product/categories/[i:id]/edit',
    'App\Controllers\Admin\ProductCategoryController@edit', 'edit_product_category');


$router->map('POST', '/admin/product/categories/[i:id]/delete',
    'App\Controllers\Admin\ProductCategoryController@delete', 'delete_product_category');

/**
 * subcategory routes
 */
$router->map('POST', '/admin/product/subcategory/create',
    'App\Controllers\Admin\SubCategoryController@create', 'create_subcategory');

$router->map('POST', '/admin/product/subcategory/[i:id]/edit',
    'App\Controllers\Admin\SubCategoryController@edit', 'edit_subcategory');

$router->map('POST', '/admin/product/subcategory/[i:id]/delete',
    'App\Controllers\Admin\SubCategoryController@delete', 'delete_subcategory');

/**
 * Product routes
 */
$router->map('GET', '/admin/category/[i:id]/selected',
    'App\Controllers\Admin\ProductController@getSubcategories', 'selected_category');


$router->map('GET', '/admin/product/create',
    'App\Controllers\Admin\ProductController@showCreateProductForm', 'create_product_form');


$router->map('POST', '/admin/product/create',
    'App\Controllers\Admin\ProductController@create', 'create_product');


$router->map('GET', '/admin/products',
    'App\Controllers\Admin\ProductController@show', 'show_products');


$router->map('GET', '/admin/product/[i:id]/edit',
    'App\Controllers\Admin\ProductController@showEditProductForm', 'edit_product_form');


$router->map('POST', '/admin/product/edit',
    'App\Controllers\Admin\ProductController@edit', 'edit_product');


$router->map('POST', '/admin/product/[i:id]/delete',
    'App\Controllers\Admin\ProductController@delete', 'delete_product');


/**
 * User routes
 */
$router->map('GET', '/admin/users',
    'App\Controllers\Admin\UserController@show', 'show_users');

$router->map('GET', '/admin/users/payments',
    'App\Controllers\Admin\PaymentController@show', 'show_users_payments');

$router->map('GET', '/admin/users/orders',
    'App\Controllers\Admin\OrderController@show', 'show_users_orders');


/**
 * Messages routes
 */
$router->map('GET', '/admin/messages',
    'App\controllers\Admin\MessageController@show', 'show_messages');

$router->map('GET', '/admin/message/view',
    'App\controllers\Admin\MessageController@show', 'view_message');

$router->map('POST', '/admin/message/[i:id]/delete',
    'App\Controllers\Admin\MessageController@delete', 'delete_message');


/**
 * Pages routes
 */
$router->map('GET', '/admin/pages',
    'App\controllers\admin\PageController@show', 'show_pages');

$router->map('GET', '/admin/page/view',
    'App\controllers\admin\PageController@show', 'view_page');

$router->map('POST', '/admin/page/[i:id]/delete',
    'App\Controllers\admin\PageController@delete', 'delete_page');


/**
 * Settings
 */
$router->map('GET', '/admin/settings',
    'App\controllers\admin\SettingsController@show', 'show_settings');


$router->map('POST', '/admin/settings/update',
    'App\Controllers\admin\SettingsController@update', 'update_settings');



/**
 * Banners routes
 */
$router->map('GET', '/admin/banners',
    'App\controllers\admin\BannerController@show', 'show_banners');

$router->map('GET', '/admin/banner/[i:id]/edit',
    'App\controllers\admin\BannerController@edit', 'edit_banner');

$router->map('POST', '/admin/banner/[i:id]/delete',
    'App\Controllers\admin\BannerController@delete', 'delete_banner');

$router->map('POST', '/admin/banner/[i:id]/update',
    'App\Controllers\admin\BannerController@update', 'update_banner');

$router->map('GET', '/admin/banner/create',
    'App\Controllers\Admin\BannerController@showCreateBannerForm', 'create_banner_form');