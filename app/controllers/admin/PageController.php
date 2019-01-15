<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 22:19
 */

namespace App\controllers\admin;


use App\classes\CSRFToken;
use App\classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\classes\Session;
use App\Controllers\BaseController;
use App\classes\ValidateRequest;
use App\models\Page;


class PageController extends BaseController
{

    public $table_name = 'pages';
    public $messages;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->messages = Page::all();
        $total = Page::all()->count();
        $object = new Page;


        list($this->pages, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $pages = $this->pages;
        $links = $this->links;

        return view('admin/pages/pages', compact('pages', 'links'));
    }

    public function edit($id)
    {

        $page = Page::where('id', $id)->first();


        return view('admin/pages/edit', compact('page'));
    }

    /**
     * @param $id
     * @return null
     * @throws \Exception
     */
    public function delete($id)
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken($request->token)){

                Page::destroy( $id);


                Session::add('success', 'Page has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/pages');

                exit;
            }
             throw new \Exception('Token mismatch.');
        }

        return null;
    }

}