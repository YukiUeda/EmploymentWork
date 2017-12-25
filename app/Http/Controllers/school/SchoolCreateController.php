<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Http\Requests\school\SchoolRequest;
use App\SchoolTeacherCode;
use App\School;
use Illuminate\Support\Facades\Hash;


class SchoolCreateController extends Controller
{
    /**
     * 初期起動時に動くメッソド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('school.create');
    }

    /**
     * 学校のアカウント作成のメソッド
     * @param SchoolRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(SchoolRequest $request){
        //入力された情報の設定
        $school = new School;
        $school->name             = $request->post('name');
        $school->address          = $request->post('address');
        $school->password         = Hash::make($request->post('password'));
        $school->telephone_number = $request->post('telephone_number');
        $school->semester = $request->post('semester');
        $school->email = $request->post('email');
        //インサート
        $school->save();
        //ページ移動
        return view('school.create');
    }

    /**
     * 教師アカウントを作成する際のコード作成
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCode(){
        //ログインしているユーザ情報取得
        $school = \Auth::user();
        $name   = $school->name;
        //アカウント作成コードの存在チェック
        $judge = true;
        $strCode = str_random(4);
        while($judge){
            //教師アカウント作成コード
            $strCode = str_random(4);

            //利用されていないコードで同じのを取得
            $colCode = SchoolTeacherCode::where('code',$strCode)->where('flg',"0")->get();

            //レコードが存在してなかったらループを抜ける
            if(0 === count($colCode)){
                $judge = false;
            }
        }

        $teacherCode = new SchoolTeacherCode;
        $teacherCode->code = $strCode;
        $teacherCode->flg = 0;
        $teacherCode->school_id = $school->id;
        $teacherCode->save();

        return view('school.code',compact("strCode",'name'));
    }
}
