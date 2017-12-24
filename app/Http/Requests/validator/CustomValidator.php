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
        $key    = explode('.',$attribute);
        $values = $data[$key[0]];
        //多重配列にも対応
        for($i=1;$i<count($key)-1;$i++){
            $values = $values[$key[$i]];
        }
        //重複チェック
        for($i=0; $i< count($values) ; $i++) {
            if($key[count($key)-1] != $i) {
                if($value == $values[$i]){
                    return false;
                }
            }
        }
        return true;
    }
}