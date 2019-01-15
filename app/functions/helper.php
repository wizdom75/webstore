<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 28/03/2018
 * Time: 22:11
 */

use Philo\Blade\Blade;
use voku\helper\Paginator;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\classes\Session;
use App\models\User;


/**
 * @param $path
 * @param array $data
 */
function view($path, $data=[])
{
    $view = __DIR__.'/../../resources/views';
    $cache = __DIR__.'/../../bootstrap/cache';


    $blade = new Blade($view, $cache);
    echo $blade->view()->make($path, $data)->render();
}

/**
 * @param $filename
 * @param $data
 * @return string
 */
function make($filename, $data)
{
    extract($data);

    ob_start();

    // Include template
    include(__DIR__.'/../../resources/views/emails/'.$filename.'.blade.php');

    //get contents on file
    $content = ob_get_contents();

    //delete that output and turn on the output buffering
    ob_end_clean();

    return $content;
}

/**
 * @param $value
 * @return string
 */
function slug($value){

    //Remove all the characters not in this list: underscore | Letter | numbers | whitespace

    $value = preg_replace('![^'.preg_quote('_').'\pL\pN\s]+!u', '', mb_strtolower($value));

    // Replace underscore with a dash
    $value = preg_replace('!['.preg_quote(' ').']+!u', '-', $value);

    //Remove whitespace
    return trim($value, '-');


}

/**
 * @param $number_of_records
 * @param $total_records
 * @param $table_name
 * @param $object
 * @return array
 */
function paginate($number_of_records, $total_records, $table_name, $object){


    $pages = new Paginator($number_of_records, 'p');
    $pages->set_total($total_records);

    $data = Capsule::select("SELECT * FROM $table_name WHERE deleted_at is null ORDER BY created_at DESC". $pages->get_limit());

    $categories = $object->transform($data);

    return [$categories, $pages->page_links()];
}

/**
 * @return bool
 * @throws Exception
 */
function isAuthenticated()
{
    return Session::has('SESSION_USER_NAME')? true : false;
}

/**
 * @return bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
 * @throws Exception
 */
function user()
{
    if(isAuthenticated()){
        return User::findOrFail(Session::get('SESSION_USER_ID'));
    }
    return false;
}

/**
 * @param $value
 * @return float|int
 */
function convertMoneyToCents($value)
{
    $value = preg_replace("/\,/i", "", $value);

    $value = preg_replace("/([^0-9\.\-])/i", "", $value);

    if(!is_numeric($value)){
        return 0.00;
    }

    $value = (float) $value;
    return round($value, 2) * 100;
}

/**
 * @param $slug
 * @param $table_name
 * @return \Illuminate\Database\Eloquent\Model|null|static
 */
function getIdOfSlug($slug, $table_name)
{

    $data = Capsule::table($table_name)->where('slug', '=', $slug['slug'])->first();

    return $data;
}

/**
 * @param $item
 * @return mixed
 */
function getSettings($item)
{
   $data = Capsule::table('settings')->first();
   return $data->$item;

}