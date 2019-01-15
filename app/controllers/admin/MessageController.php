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
use App\models\Message;
use App\models\Order;

class MessageController extends BaseController
{

    public $table_name = 'messages';
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


        $this->messages = Message::all();
        $total = Message::all()->count();
        $object = new Message;


        list($this->messages, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $messages = $this->messages;
        $links = $this->links;

        return view('admin/messages/messages', compact('messages', 'links'));
    }

    public function showReadMessage($id)
    {

        $message = Message::where('id', $id)->first();


        // Mark email as read

        if($message){
            Message::where('id', $message->id)->update(['message_read' => 1]);
        }


        return view('admin/read-message', compact('message'));
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

                Message::destroy( $id);


                Session::add('success', 'Message has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/messages');

                exit;
            }
             throw new \Exception('Token mismatch.');
        }

        return null;
    }

}