<?php
$router->map('GET', '/register', 'App\Controllers\AuthController@showRegisterForm', 'register');
$router->map('POST', '/register', 'App\Controllers\AuthController@register', 'register_me');

$router->map('GET', '/login', 'App\Controllers\AuthController@showLoginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\AuthController@login', 'log_me_in');

$router->map('GET', '/logout', 'App\Controllers\AuthController@logout', 'logout');

$router->map('GET', '/reset/password', 'App\controllers\AuthController@showForm', 'show_form');
$router->map('POST', '/reset/password', 'App\controllers\AuthController@sendRestLink', 'send_reset_link');

$router->map('GET', '/reset-password/[*:reset_token]', 'App\controllers\AuthController@showResetForm', 'show_reset_form');
$router->map('POST', '/reset-password', 'App\controllers\AuthController@processReset', 'process_reset');