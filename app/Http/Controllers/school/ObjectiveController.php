<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Http\Requests\school\ObjectiveChoice;
use App\Http\Requests\school\ObjectSetting;
use App\Objective;
use App\SchoolObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ObjectiveController extends Controller
{
    /**
     * 初期起動時に動くメッソド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $school = \Auth::user();
        $name   = $school->name;
        return view('school.objective_choice',compact('name'));
    }

    /**
     * 目標設定画面を表示する目標のデータ取得
     * @param ObjectiveChoice $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choice(ObjectiveChoice $request){
        //ログインユーザーデータ取得
        $school   = \Auth::user();
        $id       = $school->id;
        $name     = $school->name;
        $semester = $school->semester;

        //入力されたデータ取得
        $year      = date('Y')+$request->year;
        $grade   = $request->grade;
        $subject = $request->subject;

        //すでに登録されている目標を取得するための変数
        $objective = array();

        //登録されているデータを学期ごとに取得
        for($i = 1; $i <= $semester; $i++){
            $objective[$i] = SchoolObjective::query()->join('objectives','objective_id','=','objectives.id')
                ->where('school_id',$id)->where('school_grade',$grade)->where('year',$year)
                ->where('semester',$i)->where('subject',$subject)->pluck('name');
        }
        return view('school.objective_setting',compact('name','objective','year','grade','subject'));
    }

    /**
     * 目標を登録
     * @param ObjectSetting $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postetting(ObjectSetting $request){
        //ログインユーザのデータ取得
        $school   = \Auth::user();
        $id       = $school->id;
        $semester = $school->semester;
        $name     = $school->name;

        //入力データの取得
        $objective = $request->objective;
        $grade     = $request->grade;
        $subject     = $request->subject;
        $year      = date('Y')+$request->year;

        for ($i=1;$i<=$semester;$i++){
            //学期、年、科目、ログインユーザで取得データの絞り込み
            $SchoolObjective = SchoolObjective::query()->where('school_id','=',$id)->where('school_grade',$grade)
                ->where('year',$year)->where('semester','=',$i)->where('subject','=',$subject)->get();
            //目標が登録されているかチェック
            if(isset($objective[$i])){
                //目標が入力された分回す
                for ($j=0;$j<count($objective[$i]);$j++){
                    //目標テーブルに存在しているかチェック
                    $object = Objective::query()->where('name','=',$objective[$i][$j])->exists();
                    if($object){
                        //存在していたらデータ取得
                        $object = Objective::query()->where('name','=',$objective[$i][$j])->get();
                    }else{
                        //存在していなかったら登録
                        $object = new Objective;
                        $object->name = $objective[$i][$j];
                        $object->save();
                    }
                    //学校目標テーブルにすでに登録されているかのチェック
                    if(isset($SchoolObjective[$j])){
                        //登録されているとデータ更新
                        $SchoolObjective[$j]->objective_id = $object[0]->id;
                        $SchoolObjective[$j]->update();
                    }else{
                        //登録されていない場合新規登録
                        $school_objective = new SchoolObjective;
                        $school_objective->school_id    = $id;
                        $school_objective->objective_id = $object[0]->id;
                        $school_objective->school_grade = $grade;
                        $school_objective->year         = $year;
                        $school_objective->semester     = $i;
                        $school_objective->subject      = $subject;
                        $school_objective->save();
                    }
                }
            }else{
                $j = 0;
            }
            //学校目標テーブルの更新しきれなかったデータは全て削除
            for(;$j < count($SchoolObjective);$j++){
                $SchoolObjective[$j]->delete();
            }
        }

        return view('school.objective_success',compact('name'));

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
            $year            = $_old_input['year'];
            $grade           = $_old_input['grade'];
            $objective = $_old_input['objective'];
            $subject   = $_old_input['subject'];
            //各値のnullチェック

            if (isset($year) && isset($grade) && isset($objective) && isset($subject)){
                //ログイン中のアカウント情報
                $school = \Auth::user();
                $name   = $school->name;

                return view('school.objective_setting',compact('name','objective','subject','year','grade'));
            }
        }
        return redirect('/school/objective/choice');
    }

    /**
     * autoCompleteの曖昧検索
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(){
        //一覧取得
        $objectives = Objective::all();
        $objective = array();
        //autoComplete向けにデータ整形
        foreach ($objectives as $value){
            $name = $value->name;
            $objective[$name] = '';
        }
        return \Response::json($objective);
    }
}
