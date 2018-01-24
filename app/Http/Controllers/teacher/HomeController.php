<?php

namespace App\Http\Controllers\teacher;

use App\Http\Requests\teacher\CalenderRequest;
use App\SchoolCurriculum;
use App\SchoolWeekdaySchedule;
use App\User;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:teacher_account');
    }

    /**
     * TOPページ表示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.top');
    }

    /**
     * カレンダーのデータ取得
     * @param CalenderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calender(CalenderRequest $request){
        //ユーザ情報取得
        $teacher = \Auth::user();
        //カレンダーの取得範囲
        $start = $request->start;
        $end   = $request->end;

        //取得範囲のカリキュラムを取得
        $curriculums = SchoolCurriculum::join('curriculums','curriculum_id','=','curriculums.id')
            ->join('school_time_tables','school_time_tables.id','time_table_id')
            ->where('teacher_id','=',$teacher->id)
            ->where('date','<',$end)
            ->where('date','>',$start)->get();

        //返すためのデータに整形
        $calendar = array();
        foreach ($curriculums as $curriculum){
            $calendar[] = array(
                'title'=>$curriculum->title,
                'start'=>$curriculum->date.'T'.$curriculum->start,
                'end'  =>$curriculum->date.'T'.$curriculum->end,
                'url'  =>\Request::root().'/teacher/curriculum/'.$curriculum->curriculum_id,
                'color'=> '#26a69a'
            );
        }

        $time_start = strtotime($start);

        //通常の時間割をカレンダーの範囲で取得
        //曜日ごとに取得
        for ($i = 0;$i < 7;$i++){
            //今の年度の取得
            $year = date('Y',strtotime('-3 month',$time_start));
            //始まりの年の時間割取得
            $weekdays = SchoolWeekdaySchedule::query()
                ->join('teacher_classes','class_id','=','teacher_classes.id')
                ->join('school_time_tables','timetable_id','=','school_time_tables.id')
                ->where('teacher_classes.teacher_id','=',$teacher->id)
                ->where('school_weekday_schedules.year','=',$year)
                ->where('week','=',date('w',strtotime($i.' day',$time_start)))
                ->get();

            $flg = true;
            //７日単位で進む
            for ($j=0;$flg;$j++) {
                //取得したい日にちを超えたら終わり
                if (strtotime($end) > strtotime($j * 7 + $i . ' day', $time_start)){
                    //取得したい日にちが年度が変わっていたら取得する年度の切り替え
                    $date = date('Y-m-d',strtotime($j * 7 + $i . ' day', $time_start));
                    if($year != date('Y',strtotime($j * 7 + $i . ' day -3 month', $time_start))){
                        $year = date('Y',strtotime($j * 7 + $i . ' day -3 month', $time_start));
                        $weekdays = SchoolWeekdaySchedule::query()
                            ->join('teacher_classes','class_id','=','teacher_classes.id')
                            ->join('school_time_tables','timetable_id','=','school_time_tables.id')
                            ->where('teacher_classes.teacher_id','=',$teacher->id)
                            ->where('school_weekday_schedules.year','=',$year)
                            ->where('week','=',date('w',strtotime($i.' day',$time_start)))
                            ->get();
                    }
                    //カレンダーにセットするデータの整形
                    foreach ($weekdays as $weekday) {
                        $calendar[] = array(
                            'title' => \Config::get('const.curriculum')[$weekday->subject],
                            'start' => $date . 'T' . $weekday->start,
                            'end'   => $date . 'T' . $weekday->end,
                            'color' => '#ee6e73'
                        );
                    }
                }
                else{
                    $flg = false;
                }
            }
        }
        //json形式で返す
        return \Response::json($calendar);
    }
}
