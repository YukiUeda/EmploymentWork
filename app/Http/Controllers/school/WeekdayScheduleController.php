<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Http\Requests\school\ClassGrade;
use App\Http\Requests\school\WeekdaySetting;
use App\SchoolTimeTable;
use App\SchoolWeekdaySchedule;
use App\TeacherClass;
use Illuminate\Http\Request;

class WeekdayScheduleController extends Controller
{
    /**
     * 初期起動時に動くメッソド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('school.class_weekday');
    }

    /**
     * 時間割設定画面の表示
     * @param ClassGrade $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postSetting(ClassGrade $request){
        //ログイン中のアカウント情報
        $school = \Auth::user();
        $id     = $school->id;

        //入力された翌年か当年かの値
        $request_year = $request->year;
        $year = date('Y',strtotime('-3 month',time()))+$request_year;

        //入力された学年データ
        $grade = $request->grade;

        $class = TeacherClass::query()
            ->where('school_id','=',$id)
            ->where('year','=',$year)
            ->where('school_grade','=',$grade)->get();

        $timetable   = SchoolTimeTable::query()
            ->where('school_id','=',$id)->get();

        return view('school.schedules_weekday',compact('class','timetable','request_year'));
    }

    /**
     * getで送られた時に表示するデータの切り替え
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getSetting(Request $request){
        //セッションに設定されている_old_inputを取得
        $_old_input   = $request->session()->get('_old_input');
        //$_old_inputのnullチェック
        if(isset($_old_input)){
            //ログイン中のアカウント情報
            $school = \Auth::user();
            $id     = $school->id;

            //入力された翌年か当年かの値
            $request_year = $request->year;
            $year = date('Y',strtotime('-3 month',time()))+$request_year;

            //入力された学年データ
            $grade = $request->grade;

            $class = TeacherClass::query()
                ->where('school_id','=',$id)
                ->where('year','=',$year)
                ->where('school_grade','=',$grade)->get();

            $timetable   = SchoolTimeTable::query()
                ->where('school_id','=',$id)->get();
            return view('school.schedules_weekday',compact('class','timetable','request_year'));
        }else{
            return redirect('/school/class/weekday');
        }
    }

    /**
     * 時間割設定
     * @param WeekdaySetting $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postSave(WeekdaySetting $request){
        $school = \Auth::user();
        $id = $school->id;

        //各データの取得
        $class    = $request->class;
        $week     = $request->week;
        $year     = date('Y',strtotime('-3 month',time()))+$request->year;
        $subjects = $request->subject;

        //学校の時間設定を取得
        $timetable = SchoolTimeTable::query()->where('school_id','=',$id)->get();
        $i = 0;
        foreach ($subjects as $subject){
            //時間割の存在チェック
            $exist = SchoolWeekdaySchedule::query()
                ->where('year','=',$year)
                ->where('week','=',$week)
                ->where('class_id','=',$class)
                ->where('timetable_id','=',$timetable[$i]->id)
                ->exists();
            if($exist){
                //時間割の更新
                $school_week = SchoolWeekdaySchedule::query()
                    ->where('year','=',$year)
                    ->where('week','=',$week)
                    ->where('class_id','=',$class)
                    ->where('timetable_id','=',$timetable[$i]->id)
                    ->get();

                $school_week[0]->class_id     = $class;
                $school_week[0]->subject      = $subject;
                $school_week[0]->update();
            }else{
                //時間割の追加
                $school_week = new SchoolWeekdaySchedule;
                $school_week->class_id     = $class;
                $school_week->timetable_id = $timetable[$i]->id;
                $school_week->year         = $year;
                $school_week->week         = $week;
                $school_week->subject      = $subject;
                $school_week->save();
            }
            $i++;
        }

        $school_week = SchoolWeekdaySchedule::query()
            ->where('year','=',$year)
            ->where('class_id','=',$class)
            ->where('week','=',$week)
            ->get();
        for (;$i < count($school_week);$i++){
            //余った分は物理削除
            $school_week[$i]->delete();
        }

        return view('school.objective_success');
    }


    //時間割のデータ取得
    public function weekdaySetting(Request $request){
        $weekdays = SchoolWeekdaySchedule::query()
            ->where('year','=',date('Y',strtotime('-3 month',time()))+$request->year)
            ->where('week','=',$request->week)
            ->where('class_id','=',$request->class)
            ->get();
        
        $subject = array();
        foreach ($weekdays as $weekday){
            $subject[] = $weekday->subject;
        }

        return \Response::json($subject);
    }
}
