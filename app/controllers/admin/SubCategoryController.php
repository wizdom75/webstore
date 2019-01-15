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
use App\models\Category;
use App\classes\ValidateRequest;
use App\models\SubCategory;

class SubCategoryController extends BaseController
{

    public function __construct()
    {
        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }
    }

    /**
     * @return null|void
     * @throws \Exception
     */
    public function create()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            $extra_errors = [];

            if(CSRFToken::verifyCRFToken($request->token, false)){

                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'string' => true ],
                    'category_id' => ['required' => true ]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);

                $duplicate_subcategory = SubCategory::where('name', $request->name)->where('category_id', $request->category_id)->exists();

                if($duplicate_subcategory){
                    $extra_errors['name'] = array('Subcategory already exists');
                }

                $category = Category::where('id', $request->category_id)->exists();

                if(!$category){
                    $extra_errors['name'] = array('Invalid product category');
                }

                if($validate->hasError() || $duplicate_subcategory || !$category){


                    $errors = $validate->getErrorMessages();

                    count($extra_errors) ? $response = array_merge($errors, $extra_errors): $response = $errors;

                    header('HTTP/1.1 422 Un-processable entity', true, 422);
                    echo json_encode($response);

                    exit;
                }

                //Process form data
                SubCategory::create([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'slug' => slug($request->name)
                ]);
                echo json_encode(['success' => 'Subcategory created successfully']);
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
            $extra_errors = [];

            if(CSRFToken::verifyCRFToken($request->token, false)){

                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'string' => true ],
                    'category_id' => ['required' => true ]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);

                $duplicate_subcategory = SubCategory::where('name', $request->name)->where('category_id', $request->category_id)->exists();

                if($duplicate_subcategory){
                    $extra_errors['name'] = array('You have not made any changes');
                }

                $category = Category::where('id', $request->category_id)->exists();

                if(!$category){
                    $extra_errors['name'] = array('Invalid product category');
                }

                if($validate->hasError() || $duplicate_subcategory || !$category){


                    $errors = $validate->getErrorMessages();

                    count($extra_errors) ? $response = array_merge($errors, $extra_errors): $response = $errors;

                    header('HTTP/1.1 422 Un-processable entity', true, 422);
                    echo json_encode($response);

                    exit;
                }

                SubCategory::where('id', $id)->update(['name' => $request->name, 'category_id' => $request->category_id]);
                echo json_encode(['success' => 'SubCategory update was successful']);
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

                SubCategory::destroy( $id);

                Session::add('success', 'SubCategory has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/product/categories');

            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }
}