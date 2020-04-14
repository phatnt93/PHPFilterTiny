<?php 


/** 
* PHP Filter Tiny Library
* Help filter quickly.
*
* Made by phatnt93
* 02/04/2020
* 
* @license MIT License
* @author phatnt <thanhphat.uit@gmail.com>
* @github https://github.com/phatnt93/PHPFilterTiny
* @version 1.0.0
* 
*/

namespace PHPFilterTiny;

/**
 * 
 */
class PHPFilterTiny{
    public $error = false;
    public $msg = '';

    function __construct(){

    }

    /**
     * Run filter
     * @param  [array] $params [description]
     * @param  [array] $filter [description]
     * @return [type]         [description]
     */
    public function run($params, $filter){
        try {
            // Check params
            $this->checkParams($params);
            // Check filter
            $this->checkFilter($filter);
            // Run filter
            foreach ($filter as $kf => $item) {
                if (!array_key_exists($kf, $params)) {
                    throw new \Exception($kf . " was not found");
                }
                $arrFunc = array_filter(explode('|', $item));
                foreach ($arrFunc as $kfunc => $ifunc) {
                    $nameFunc = strtolower($ifunc);
                    if (!method_exists($this, $nameFunc)) {
                        throw new \Exception($nameFunc . " method was not found");
                    }
                    $params[$kf] = $this->$nameFunc($params[$kf]);
                }
            }
        } catch (\Exception $e) {
            $this->error = true;
            $this->msg = $e->getMessage();
        }
        return $params;
    }

    protected function checkParams($params){
        if (!is_array($params)) {
            throw new \Exception("Params must be array");
        }
        if (count(array_filter($params)) == 0) {
            throw new \Exception("Params empty");
        }
    }

    protected function checkFilter($filter){
        if (!is_array($filter)) {
            throw new \Exception("Filter must be array");
        }
        if (count(array_filter($filter)) == 0) {
            throw new \Exception("Filter empty");
        }
    }

    // Sanitize_string
    private function string($value){
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    private function urlencode($value){
        return filter_var($value, FILTER_SANITIZE_ENCODED);
    }

    private function htmlencode($value){
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    private function email($value){
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    private function numbers($value){
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    private function floats($value){
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    private function lower_case($value){
        return strtolower($value);
    }

    private function upper_case($value){
        return strtoupper($value);
    }

    private function slug($value) {
        $delimiter = '-';
        $value = trim(mb_strtolower($value));
        $value = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $value);
        $value = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $value);
        $value = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $value);
        $value = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $value);
        $value = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $value);
        $value = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $value);
        $value = preg_replace('/(đ)/', 'd', $value);
        $value = preg_replace('/[^a-z0-9-\s]/', '', $value);
        $value = preg_replace('/([\s]+)/', $delimiter, $value);
        return $value;
    }

    private function trim($value){
        return trim($value);
    }


}
