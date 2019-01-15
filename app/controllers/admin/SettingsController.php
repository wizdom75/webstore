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
use App\models\Setting;

class SettingsController extends BaseController
{

    public $table_name = 'settings';
    public $settings;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->settings = Setting::all();
        $total = Setting::all()->count();
        $object = new Setting();


        list($this->settings, $this->links) = paginate(10, $total, $this->table_name, $object);

    }

    /**
     * Show method
     */
    public function show()
    {


        $settings = $this->settings;
        $links = $this->links;

        return view('admin/settings/settings', compact('settings', 'links'));
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function update()
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken($request->token, false)) {

                $rules = [
                    'telephone' => ['required' => true, 'minLength' => 4, 'maxLength' => 70],
                    'address' => ['required' => true, 'minLength' => 2]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);



                if ($validate->hasError()) {


                    $response = $validate->getErrorMessages();

                    $errors = $response;

                    return view('admin/settings/settings', [

                        'errors' => $errors,
                        'settings' => $this->settings
                    ]);
                }

                $setting = Setting::findOrFail($request->id);
                $setting->address = $request->address;
                $setting->telephone = $request->telephone;


                $setting->save();

                Session::add('success', 'Settings have been updated');
                Request::refresh();

                Redirect::to(getenv('APP_URL').'/admin/settings');
                exit;
            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }



}