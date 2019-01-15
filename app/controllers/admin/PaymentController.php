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
use App\models\Payment;
use App\models\User;

class PaymentController extends BaseController
{

    public $table_name = 'payments';
    public $payments;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->payments = Payment::all();
        $total = Payment::all()->count();
        $object = new Payment;


        list($this->payments, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $payments = $this->payments;
        $links = $this->links;

        return view('admin/users/payments', compact('payments', 'links'));
    }

    public function showEditUserForm($id)
    {
        $payments = $this->payments;
        $payments = Payment::where('id', $id)->first();

        return view('admin/users/payments/edit', compact('payments'));
    }



}