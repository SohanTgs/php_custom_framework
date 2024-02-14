<?php

namespace App;

use App\Validator\Validator;

class Request{

    private $all = [];
    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                $value = trim($value);
            }
            $this->$key = $value;
            $this->all[$key] = $value;
        }
        foreach ($_FILES as $key => $value) {
            $this->$key = $value;
            $this->all[$key] = $value;
        }
        foreach ($_GET as $key => $value) {
            if (!is_array($value)) {
                $value = trim($value);
            }
            $this->$key = $value;
            $this->all[$key] = $value;
        }
    }

    public function hasFile($keyName)
    {
        if(array_key_exists($keyName,$_FILES) && array_key_exists('name',$_FILES[$keyName])){
            if(is_array($_FILES[$keyName]['name'])){
                if(array_key_exists(0,$_FILES[$keyName]['name'])){
                    return true;
                }else{
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function file($file)
    {
        $filePath = $file['full_path'];
        return toObject(pathinfo($filePath,PATHINFO_ALL));
    }

    public function files($key){
        $files = $_FILES[$key];
        $fileGroup = [];
        foreach($files['name'] as $index => $file){
            $fileGroup[] = [
                'name'=>$files['name'][$index],
                'full_path'=>$files['full_path'][$index],
                'type'=>$files['type'][$index],
                'tmp_name'=>$files['tmp_name'][$index],
                'error'=>$files['error'][$index],
                'size'=>$files['size'][$index],
                'direct_file'=>true
            ];
        }

        return $fileGroup;
    }

    public function all()
    {   
        return $this->all;
    }

    public function validate($rules,$customMessages = [])
    {   
        $validations = Validator::make($rules,$customMessages);
        if (!empty($validations['errors'])) { 
            foreach ($this->all as $key => $value) {
                session()->flash('old_input_value_'.$key,$value);
            }
            session()->flash('errors',$validations['errors']);
            redirectBack();
        }
    }

    public function __get($name)
	{
		if (isset($this->$name)) {
			return $this->$name;
		}
        return null;
	}
}