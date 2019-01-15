<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\models\Message;
use App\classes\Request;
use App\classes\ValidateRequest;
use App\classes\Session;
use App\classes\Redirect;
use App\classes\Mail;

class MessageController extends BaseController
{

    public $table_name = 'messages';
    public $links;



    /**
     * @return null|void
     * @throws \Exception
     */
    public function create()
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken(($request->token))){

                $rules = [
                    'sender_name' => ['required' => true, 'minLength' => 3, 'string' => true],
                    'sender_email' => ['required' => true],
                    'message' => ['required' => true]

                ];


                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);

                if($validate->hasError()){


                    $errors = $validate->getErrorMessages();

                    header('HTTP/1.1 422 Unprocessable entity', true, 422);
                    echo json_encode($errors);

                    exit;
                }

                //Process form data
                Message::create([
                    'sender_name' => $request->fullname,
                    'sender_email' => $request->email,
                    'message' => $request->message
                ]);


                $data = [
                    'to' => getenv('ADMIN_EMAIL'),
                    'subject' => 'Message from RojoHammer',
                    'view' => 'message',
                    'name' => $request->fullname,
                    'body' => $request->message
                ];

                (new Mail())->send($data);

                Session::add('success', 'Your message has been successfully sent.');
                Redirect::to(getenv(APP_URL).$request->return);

                exit;
            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }


    /**
     * @param $id
     * @return null
     * @throws \Exception
     */
    public function edit($id)
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken($request->token, false)){

                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'string' => true, 'unique' => 'categories']

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);

                if($validate->hasError()){

                    $errors = $validate->getErrorMessages();

                    header('HTTP/1.1 422 Unprocessable entity', true, 422);
                    echo json_encode($errors);

                    exit;
                }

                Category::where('id', $id)->update(['name' => $request->name]);
                echo json_encode(['success' => 'Category update was successful']);
                exit;


            }
            throw new \Exception('Token mismatch.');
        }

        return null;
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

                Category::destroy( $id);


                $subcategories = SubCategory::where('category_id', $id)->get();

                if(count($subcategories)){

                    foreach($subcategories as $subcategory){
                        $subcategory->delete();
                    }
                }

                Session::add('success', 'Category has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/product/categories');

            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }

}