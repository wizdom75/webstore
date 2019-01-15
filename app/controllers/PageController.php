<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\models\Page;

class PageController extends BaseController
{

    /**
     * @param $slug
     * @throws \Exception
     */
    public  function show($slug)
    {
        $token = CSRFToken::_token();
        $page = Page::where('slug', $slug)->first();

        //$page['body'] = nl2br($page['body']);

        return view('page', compact('token', 'page'));
    }

    /**
     * @param $slug
     * @throws \Exception
     */
    public  function showDetails($slug)
    {
        $page = Page::where('slug', $slug)->first();

        $page['body'] = nl2br($page['body']);

        if($page){

            echo json_encode([
                'page' => $page
            ]);
            exit;
        }
        header('HTTP/1.1 422 Uprocessable entity', true, 422);
        echo 'Page not found';
        exit;
    }
}