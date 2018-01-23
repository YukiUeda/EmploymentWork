<?php

namespace App\Http\Controllers\teacher;

use App\Http\Requests\teacher\TeacherRequest;
use App\Http\Controllers\Controller;
use App\SchoolTeacherCode;
use App\TeacherAccount;
use Illuminate\Support\Facades\Hash;


class TeacherCreateController extends Controller
{
    /**
     * 教員作成ページ
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("teacher.create");
    }

    /**
     * 教員作成処理
     * @param TeacherRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TeacherRequest $request)
    {
        //codeが有効化の確認
        $code = $request->code;
        $teacher_code = new SchoolTeacherCode;
        $tbCode = $teacher_code->query()->where('code',$code)->where('flg','0')->get();
        if(0<count($tbCode)){
            //アカウント作成
            $teacher_accounts = new TeacherAccount();
            $teacher_accounts->school_id = $tbCode[0]['school_id'];
            $teacher_accounts->name      = $request->name;
            $teacher_accounts->email     = $request->email;
            $teacher_accounts->password  = Hash::make($request->password);
            $teacher_accounts->save();

            $teacher_code = SchoolTeacherCode::find($tbCode[0]['id']);
            $teacher_code->flg = 1;
            $teacher_code->update();
        }else{
            $error = array('codeが有効ではありません');
            return view('teacher.create',compact('error'));
        }

        return view("teacher.create");
    }
}
