<?php

namespace app\lib\tools\files;


final class FilesTools
{

    private static ?FilesTools $instance = null;

    /**
     * @return FilesTools
     */
    public static function getInstance(): FilesTools
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     * multiple construct, clone, wakeup,
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}


    public function remapFileArr($files) {

        if(empty($files)) {
            return null;
        }

        $newFiles = [];
        if(isset($files['name'])) {
            foreach ($files['name'] as $index => $name) {
                $newFiles[$index]['name'] = $name;

                if(isset($files['full_path'][$index])) {
                    $newFiles[$index]['full_path'] = $files['full_path'][$index];
                }
                if(isset($files['type'][$index])) {
                    $newFiles[$index]['type'] = $files['type'][$index];
                }
                if(isset($files['tmp_name'][$index])) {
                    $newFiles[$index]['tmp_name'] = $files['tmp_name'][$index];
                }
                if(isset($files['error'][$index])) {
                    $newFiles[$index]['error'] = $files['error'][$index];
                }
                if(isset($files['size'][$index])) {
                    $newFiles[$index]['size'] = $files['size'][$index];
                }
            }
        }

        return $newFiles;
    }

}