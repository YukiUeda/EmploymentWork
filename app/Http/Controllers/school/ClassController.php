<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Http\Requests\school\ClassGrade;
use App\Http\Requests\school\ClassSetting;
use App\TeacherAccount;
use App\TeacherClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * classを設定する学年選択画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        //ログイン中のアカウント情報取得
        $school   = \Auth::user();
        $name     = $school->name;

        return view('school.class_grade',compact('name'));
    }

    /**
     * classの設定と各クラスに教員を設定
     * @param ClassGrade $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grade(ClassGrade $request) {
        //ログイン中のアカウント情報
        $school = \Auth::user();
        $name   = $school->name;
        $id     = $school->id;

        //入力された翌年か当年かの値
        $request_year = $request->year;
        $year = date('Y')+$request_year;

        //入力された学年データ
        $grade = $request->grade;

        //すでに登録されている場合のclass設定
        $class = TeacherClass::query()->where('school_id','=',$id)->where('year','=',$year)->where('school_grade','=',$grade)->get();
        if(!count($class)) {
            //すでに登録されていない場合、前年度のデータを取得
            $class = TeacherClass::query()->where('school_id','=',$id)->where('year','=',$year-1)->where('school_grade','=',$grade-1)->get();
        }

        //ログイン中の学校教師取得
        $teacher = TeacherAccount::query()->where('school_id','=',$id)->get();

        return view('school.class_setting',compact('teacher','class','name','year','grade'));
    }

    /**
     * classのデータ登録
     * @param ClassSetting $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postSetting(ClassSetting $request) {
        //ログイン中のアカウント情報取得
        $school   = \Auth::user();
        $name     = $school->name;
        $id       = $school->id;

        //入力された翌年か当年かの値
        $request_year = $request->year;
        $year = date('Y')+$request_year;

        //入力された値取得
        $grade = $request->grade;
        $class   = $request->class;
        $teacher = $request->teacher;
        //ログインしている学校の該当学年のclass取得
        $teacher_classes = TeacherClass::query()->where('school_id','=',$id)
            ->where('school_grade','=',$grade)->where('year','=',$year)->get();
        $i = 0;
        //入力された値にデータベースを更新
        foreach ($teacher_classes as $teacher_class){
            //入力された値よりデータベースの値が多いかのチェック
            if(count($class) <= $i ){
                //多い場合データ削除
                $teacher_class->delete();
            }else{
                //新しいデータに変更
                $teacher_class->class_name = $class[$i];
                $teacher_class->teacher_id = $teacher[$i];
                $teacher_class->update();
            }
            $i++;
        }
        //更新するデータがなかった場合新規追加
        for(;$i < count($class);$i++) {
            $teacher_class_save = new TeacherClass;
            $teacher_class_save->school_id    = $id;
            $teacher_class_save->teacher_id   = $teacher[$i];
            $teacher_class_save->class_name   = $class[$i];
            $teacher_class_save->school_grade = $grade;
            $teacher_class_save->year         = $year;
            $teacher_class_save->save();
        }


        return view('school.class_success',compact('name'));
    }

    /**
     * getで通信された際に表示するページ切り替え
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getSetting(Request $request){
        //セッションに設定されている_old_inputを取得
        $_old_input   = $request->session()->get('_old_input');
        //$_old_inputのnullチェック
        if(isset($_old_input)){
            //$_old_inputから値取得
            $year  = $_old_input['year'];
            $grade = $_old_input['grade'];
            $input_classes = $_old_input['class'];
            $input_teacher = $_old_input['teacher'];
            //各値のnullチェック
            if (isset($year) && isset($grade) && isset($input_classes) && isset($input_teacher)){
                //ログイン中のアカウント情報
                $school = \Auth::user();
                $name   = $school->name;
                $id     = $school->id;
                //ログイン中の学校の教師一覧取得
                $teacher = TeacherAccount::query()->where('school_id','=',$id)->get();
                //viewに初期入力の値作成
                $class = array();
                $i = 0;
                foreach ($input_classes as $input_class){
                    $class[$i] = array(
                        'class_name' => $input_class,
                        'teacher_id' => $input_teacher[$i]
                    );
                    $i++;
                }
                return view('school.class_setting',compact('teacher','class','name','year','grade'));
            }
        }
        return redirect('/school/class/grade');
    }
}
