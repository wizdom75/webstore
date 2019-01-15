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
use App\models\Banner;
use App\models\Page;


class BannerController extends BaseController
{

    public $table_name = 'banners';
    public $banners;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->banners = Banner::all();
        $total = Banner::all()->count();
        $object = new Banner;


        list($this->banners, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $banners = $this->banners;
        $links = $this->links;

        return view('admin/banners/list', compact('banners', 'links'));
    }

    public function edit($id)
    {

        $banner = Banner::where('id', $id)->first();


        return view('admin/banners/edit', compact('banner'));
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


                Session::add('success', 'Banner has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/banners/index');

                exit;
            }
             throw new \Exception('Token mismatch.');
        }

        return null;
    }

    /**
     *
     */
    public function showCreateBannerForm()
    {
        $banners = $this->banners;
        return view('admin/banners/create', compact('banners'));
    }

}