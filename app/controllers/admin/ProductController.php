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
use App\models\Category;
use App\classes\ValidateRequest;
use App\models\Product;
use App\models\SubCategory;

class ProductController extends BaseController
{

    public $table_name = 'products';
    public $categories;
    public $products;
    public $subcategories;
    public $subcategories_links;
    public $links;


    /**
     * ProductController constructor.
     */
    public function __construct()
    {

        if(!Role::middleware('admin')){
            Redirect::to(getenv('APP_URL').'/login');
        }


        $this->categories = Category::all();

        $this->products = Product::all();
        $total = Product::all()->count();

        $object = new Product;

        list($this->products, $this->links) = paginate(10, $total, $this->table_name, $object);

        //list($this->subcategories, $this->subcategories_links) = paginate(10, $subTotal, 'sub_categories', new SubCategory());
    }

    /**
     * Show method
     */
    public function show()
    {


        $products = $this->products;
        $links = $this->links;

        return view('admin/products/inventory', compact('products', 'links'));
    }

    public function showEditProductForm($id)
    {
        $categories = $this->categories;
        $product = Product::where('id', $id)->with(['category', 'subCategory'])->first();

        return view('admin/products/edit', compact('product', 'categories'));
    }

    /**
     *
     */
    public function showCreateProductForm()
    {
        $categories = $this->categories;
        return view('admin/products/create', compact('categories'));
    }

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
                    'name' => ['required' => true, 'minLength' => 3, 'maxLength' => 70, 'mixed' => true, 'unique' => $this->table_name],
                    'price' => ['required' => true, 'minLength' => 1, 'numbers' => true ],
                    'quantity' => ['required' => true ],
                    'category' => ['required' => true ],
                    'subcategory' => ['required' => true ],
                    'description' => ['required' => true, 'minLength' => 4, 'maxLength' => 500]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);


                $file = Request::get('file');

                isset($file->productImage->name) ? $filename = $file->productImage->name : $filename = '';

                $file_error = [];

                if(empty($filename)){
                    $file_error['productImage'] = ['The product image is required'];
                }elseif(!UploadFile::isImage($filename)){

                    $file_error['productImage'] = ['The image is not a valid type, Try a another one'];
                }

                if($validate->hasError()){


                    $response = $validate->getErrorMessages();

                    count($file_error) ? $errors = array_merge($response, $file_error) : $errors = $response;

                    return view('admin/products/create', [
                        'categories' => $this->categories,
                        'errors' => $errors
                    ]);
                }

                $ds = DIRECTORY_SEPARATOR;
                $temp_file = $file->productImage->tmp_name;
                $image_path = UploadFile::move($temp_file, "images{$ds}uploads{$ds}products", $filename)->path();

                //Process form data
                Product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'category_id' => $request->category,
                    'sub_category_id' => $request->subcategory,
                    'image_path' => $image_path,
                    'quantity' => $request->quantity,
                ]);

                Request::refresh();

                return view('admin/products/create', [
                    'categories' => $this->categories, 'success' => 'Product created']);
                exit;
            }
            throw new \Exception('Token mismatch.');
        }

        return null;
    }


    /**
     * @return null
     * @throws \Exception
     */
    public function edit()
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCRFToken($request->token, false)) {

                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'maxLength' => 70, 'mixed' => true],
                    'price' => ['required' => true, 'minLength' => 2, 'numbers' => true],
                    'quantity' => ['required' => true],
                    'category' => ['required' => true],
                    'subcategory' => ['required' => true],
                    'description' => ['required' => true, 'mixed' => true, 'minLength' => 4, 'maxLength' => 500]

                ];

                $validate = new ValidateRequest;

                $validate->abide($_POST, $rules);


                $file = Request::get('file');

                isset($file->productImage->name) ? $filename = $file->productImage->name : $filename = '';

                $file_error = [];

                if (isset($file->productImage->name) && !UploadFile::isImage($filename)) {

                    $file_error['productImage'] = ['The image is not a valid type, Try a another one'];
                }

                if ($validate->hasError()) {


                    $response = $validate->getErrorMessages();

                    count($file_error) ? $errors = array_merge($response, $file_error) : $errors = $response;

                    return view('admin/products/edit', [
                        'categories' => $this->categories,
                        'errors' => $errors
                    ]);
                }

                $product = Product::findOrFail($request->product_id);
                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->quantity = $request->quantity;
                $product->category_id = $request->category;
                $product->sub_category_id = $request->subcategory;

                if ($filename){

                    $ds = DIRECTORY_SEPARATOR;

                    $old_img_path = BASE_PATH."{$ds}public{$ds}$product->image_path";

                    $temp_file = $file->productImage->tmp_name;
                    $image_path = UploadFile::move($temp_file, "images{$ds}uploads{$ds}products", $filename)->path();

                    unlink($old_img_path);

                    $product->image_path = $image_path;
                }

                $product->save();

                Session::add('success', 'Record updated');
                Request::refresh();

                Redirect::to(getenv('APP_URL').'/admin/products');
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

                Product::destroy( $id);


                Session::add('success', 'Product has been deleted');
                Redirect::to(getenv(APP_URL).'/admin/products');

            }
           // throw new \Exception('Token mismatch.');
        }

        return null;
    }

    /**
     * @param $id
     */
    public function getSubcategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        echo json_encode($subcategories);
        exit;
    }
}