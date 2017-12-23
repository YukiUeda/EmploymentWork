<?php
/**
 * Created by PhpStorm.
 * User: uedayuuki
 * Date: 2017/12/24
 * Time: 0:41
 */

namespace App\Http\Requests\validator;


use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    //配列で送られた値のユニークチェック
    public function validateRequestExist($attribute, $value, $parameters,$validator){
        //リクエストの全値取得
        $data   = $validator->getData();
        $values = $data[strstr($attribute, '.', true)];
        $index  = substr(strstr($attribute,'.'),1);
        for($i=0; $i< count($values) ; $i++) {
            if( $index != $i) {
                if($value == $values[$i]){
                    return false;
                }
            }
        }
        return true;
    }
}