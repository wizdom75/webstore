<?php

namespace App\Controllers;


use App\classes\CSRFToken;
use App\classes\Redirect;
use App\classes\Request;
use App\classes\ValidateRequest;
use App\models\User;
use App\classes\Session;
use App\classes\Mail;


class AuthController extends BaseController
{

    /**
     * AuthController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if(isAuthenticated()){
            Redirect::to(getenv('APP_URL'));
        }
    }

    /**
     * Show register form
     */
    public  function showRegisterForm()
    {

        return view('register');
    }

    /**
     * Show password reset form
     */
    public  function showForm()
    {

        return view('password_reset');
    }

    /**
     * Show password reset form number 2
     */
    public  function showResetForm()
    {

        return view('password_reset2');
    }

    /**
     * Show login form
     */
    public  function showLoginForm()
    {

        return view('login');
    }

    /**
     * @return null|void
     * @throws \Exception
     *
     */
    public function register()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCRFToken($request->token)){
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'mixed' => true, 'unique' => 'users'],
                    'email' => ['required' => true,  'email' => true, 'unique' => 'users'],
                    'password' => ['required' => true, 'minLength' => 6],
                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50],
                    'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true]
                ];
                $validate = new ValidateRequest();
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('register', ['errors' => $errors]);
                }

                User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT),
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'role' => 'user'
                ]);

                Request::refresh();
                return view('register', ['success' => 'Account has been created']);
                exit;
            }
            throw new \Exception('Token mismatch');
        }
        return null;
    }

    /**
     * login method
     * @return null|void
     * @throws \Exception
     */
    public function login()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCRFToken($request->token)){
                $rules = [
                    'username' => ['required' => true],
                    'password' => ['required' => true]
                ];
                $validate = new ValidateRequest();
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('login', ['errors' => $errors]);
                }

                // Check if user exists in database

                $user = User::where('username', $request->username)
                ->orWhere('email', $request->username)->first();

                if($user){
                    if(!password_verify($request->password, $user->password)){
                        Session::add('error', 'Incorrect password');
                        return view('login');
                    }else{
                        Session::add('SESSION_USER_ID', $user->id);
                        Session::add('SESSION_USER_NAME', $user->username);

                        if($user->role == 'admin'){
                            Redirect::to(getenv('APP_URL').'/admin');
                        }elseif ($user->role == 'user' && Session::has('user_cart')){
                            Redirect::to(getenv('APP_URL')).'/cart';
                        }else{
                            Redirect::to(getenv('APP_URL'));
                        }


                    }
                }else{
                    Session::add('error', 'User not found, please check and try again.');
                    return view('login');
                }
                exit;

            }
            throw new \Exception('Token mismatch');
        }
        return null;
    }


    /**
     * logout method
     * @throws \Exception
     */
    public function logout()
    {
        if(isAuthenticated()){
            Session::remove('SESSION_USER_ID');
            Session::remove('SESSION_USER_NAME');

            if(!Session::has('user_cart')){
                session_destroy();
                session_regenerate_id(true);
            }
        }
        Redirect::to(getenv('APP_URL'));
    }

    /**
     *
     * @return null
     * @throws \Exception
     */
    public function sendRestLink()
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken($request->token, false)){

                $rules = [
                    'username' => ['minLength' => 3, 'mixed' => true],
                    'email' => ['minLength' => 3]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);

                if($validate->hasError()){

                    $errors = $validate->getErrorMessages();

                    header('HTTP/1.1 422 Unprocessable entity', true, 422);
                    echo json_encode($errors);

                    exit;
                }


                $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)->first();

                $hash_token = hash('sha256', $user->email);

                if($user){
                    User::where('username', $user->username)->update(['password_reset_hash' => $hash_token]);

                    $result['link'] = "<a href='".getenv('APP_URL').'/reset-password/'.$hash_token."'>".getenv('APP_URL').'/password/reset/'.$hash_token."</a>";
                    $result['name'] = $user->fullname;

                    $data = [
                        'to' => $user->email,
                        'subject' => 'Password reset',
                        'view' => 'password_reset',
                        'name' => $user->fullname,
                        'body' => $result
                    ];

                    (new Mail())->send($data);

                    Session::add('success', 'Reset email has been sent');
                    return view('login');

                }else{
                    Session::add('error', 'User not found, please check and try again.');
                    return view('password_reset');

                }

                exit;


            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }

    /**
     * Process ne password
     * @return null|void
     * @throws \Exception
     */
    public function processReset()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCRFToken($request->token)){
                $rules = [
                    'password' => ['required' => true],
                    'password_confirm' => ['required' => true]
                ];
                $validate = new ValidateRequest();
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('password_reset2', ['errors' => $errors]);
                }

                // Check if reset token exists in database

                $token = $request->reset_token;
                $token = explode('/', $token);


                $user = User::where('password_reset_hash', $token[2])->first();

                if($user){
                    if($request->password !== $request->password_confirm){
                        Session::add('error', 'Reset Passwords do not match');
                        return view('login');
                    }else {
                        User::where('password_reset_hash', $token[2])->update(['password' => password_hash($request->password, PASSWORD_BCRYPT)]);
                        User::where('password_reset_hash', $token[2])->update(['password_reset_hash' => NULL]);
                        Session::add('success', 'Password reset has completed successfully. You can login now');
                        return view('login');


                    }
                    exit;
                }else{
                    Session::add('error', 'User not found, please check and try again.');
                    return view('login');
                }
                exit;

            }
            throw new \Exception('Token mismatch');
        }
        return null;
    }

}