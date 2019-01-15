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
use App\classes\UploadFile;
use App\Controllers\BaseController;
use App\classes\ValidateRequest;
use App\models\Order;

class OrderController extends BaseController
{

    public $table_name = 'orders';
    public $orders;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->orders = Order::all();
        $total = Order::all()->count();
        $object = new Order;


        list($this->users, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $orders = $this->orders;
        $links = $this->links;

        return view('admin/users/orders', compact('orders', 'links'));
    }

    public function showEditUserForm($id)
    {
        $orders = $this->orders;
        $orders = Order::where('id', $id)->first();

        return view('admin/users/orders/edit', compact('orders'));
    }



}