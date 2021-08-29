<?php

namespace App\Traits;

trait Validation{

    use ResponseApi;

    /** validate data by given rule
     * @param $rule
     * @param $data
     * @param string $field
     * @return Model
     */

    public function validation($rule, $data, $field = "")
    {
        $code = "";
        $message = "";

        switch ($rule){
            case "required":{
                if(empty($data)){
                    $message = "$field is required!";
                    $code = 404;
                }
                break;
            }
            case "httpError":{
                if($data["httpCode"] != 200){
                    $message = $data["httpDescription"];
                    $code = $data["httpCode"];
                }
                break;
            }
            case "empty":{
                 if(empty($data) || (is_array($data) && count($data) == 0)){
                     $message = "$field is/are empty";
                     $code = 404;
                 }
                 break;
            }
            case "repositoryFound":{
                if(!$data){
                    $message = "$field not found";
                    $code = 404;
                }
                break;
            }
        }

        return (!empty($code))?$this->error($message, $code):false;
    }

}
