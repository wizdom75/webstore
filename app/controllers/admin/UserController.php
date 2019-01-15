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
use App\models\User;

class UserController extends BaseController
{

    public $table_name = 'users';
    public $users;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->users = User::all();
        $total = User::all()->count();
        $object = new User;


        list($this->users, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $users = $this->users;
        $links = $this->links;

        return view('admin/users/list', compact('users', 'links'));
    }

    public function showEditUserForm($id)
    {
        $users = $this->users;
        $users = User::where('id', $id)->first();

        return view('admin/users/edit', compact('users'));
    }

    /**
     *
     */
    public function showCreateUserForm()
    {
        $users = $this->users;
        return view('admin/users/create', compact('categories'));
    }


}