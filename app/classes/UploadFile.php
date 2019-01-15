<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 03/04/2018
 * Time: 18:23
 */

namespace App\classes;


class UploadFile
{
    protected $filename;
    protected $max_filesize = 2097152;
    protected $extension;
    protected $path;


    /**
     * Get the filename
     * @return mixed
     */
    public function getName()
    {
        return $this->filename;
    }


    /**
     *
     * Set name of the file
     * @param $file
     * @param string $name
     */
    protected function setName($file, $name='')
    {
        if($name=''){
            $name = pathinfo($file, PATHINFO_FILENAME);
        }

        $name = strtolower(str_replace(['_', ' '], '-', $name));

        $hash = md5(microtime());

        $ext = $this->fileExtension($file);

        $this->filename = "{$name}-{$hash}.{$ext}";
    }

    /**
     *Get the file extension
     *
     * @param $file
     * @return mixed
     */
    protected function fileExtension($file)
    {
        return $this->extension = pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * Validate file size
     * @param $file
     * @return bool
     */
    public static function fileSize($file)
    {
        $obj = new static;
        return $file > $obj->max_filesize ? true : false;
    }

    /**
     * Validate upload
     * @param $file
     * @return bool
     */
    public static function isImage($file)
    {
        $obj = new static;

        $ext = $obj->fileExtension($file);

        $validExt = array('jpg', 'jpeg', 'png', 'bmp', 'gif');

        if(!in_array(strtolower($ext), $validExt)){
            return false;
        }

        return true;

    }

    /**
     * Get the upload path
     * @return mixed
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Move the upladed file from temp directory to permanent folder
     *
     * @param $temp
     * @param $folder
     * @param $file
     * @param $new_filename
     * @return static
     */
    public static function move($temp, $folder, $file, $new_filename='')
    {
        $obj = new static;
        $ds = DIRECTORY_SEPARATOR;

        $obj->setName($file, $new_filename);

        $file_name = $obj->getName();

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $obj->path = "{$folder}{$ds}{$file_name}";

        $absolute_path = BASE_PATH."{$ds}public{$ds}$obj->path";

        if(move_uploaded_file($temp, $absolute_path)){
            return $obj;
        }

    }

}