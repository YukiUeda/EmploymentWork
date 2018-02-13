<?php

namespace App\Http\Controllers\teacher;

use App\Curriculum;
use App\CurriculumContent;
use App\CurriculumObjective;
use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\CommentRequest;
use App\Http\Requests\teacher\CurriculumTableRequest;
use App\product;
use App\ProductClick;
use App\SchoolCurriculum;
use App\SchoolObjective;
use App\SchoolTimeTable;
use Illuminate\Support\Facades\DB;


class CurriculumController extends Controller
{
    /**
     * カリキュラムのTOP画面表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $teacher = \Auth::user();
        $tId = $teacher->id;
        //今の年度を取得
        $year = date('Y',strtotime('-3 month',time()));
        //科目のリストを取得
        $subjects = \Config::get('const.curriculum');

        $curriculumList = array();

        foreach ($subjects as $key=>$subject){
            //科目の目標の類似度の高いカリキュラムを取得
            $curriculum = Curriculum::select('curriculums.*', \DB::raw('sum(1) as point'))
                ->leftJoin('curriculum_objectives','curriculum_objectives.curriculum_id' ,'=','curriculums.id')
                ->leftJoin('school_objectives','curriculum_objectives.objective_id','=','school_objectives.objective_id')
                ->where('curriculums.subject','=',$key)
                ->where('curriculums.auth','=',1)
                ->whereNotIn('curriculums.id',SchoolCurriculum::query()->select(['curriculum_id'])->where('year','=',$year)->where('teacher_id','=',$tId))
                ->groupBy('curriculums.id')->orderBy('point','desc')->limit(6)->get();
            //過去にやったカリキュラムの商品番号取得
            $curriculumProducts = SchoolCurriculum::select('product_id')
                ->join('curriculums','school_curriculums.curriculum_id','=','curriculums.id')
                ->join('products','curriculums.product_id','=','products.id')
                ->where(\DB::raw('YEAR(school_curriculums.date)'),$year)
                ->where('curriculums.subject','=',$key)
                ->where('school_curriculums.teacher_id',$tId)
                ->get();

            $point = array();
            $curriculums = array();
            foreach ($curriculum as $curri){
                foreach ($curriculumProducts as $curriculumProduct){
                    if($curriculumProduct == $curri){
                        $curri->point + 1;
                    }
                }
                $point[] = $curri->point;
                $curriculums[] = $curri;
            }
            array_multisort($point,SORT_DESC , SORT_NUMERIC , $curriculums);
            $curriculumList[] = $curriculums;
        }

        return view('teacher.curriculum_top',compact('curriculumList'));
    }

    /**
     * 詳細画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){
        $teacher = \Auth::user();
        $tId     = $teacher->id;
        $curriculum = Curriculum::find($id);
        if(!empty($curriculum)){
            $product  = product::find($curriculum->product_id);
            $contents = CurriculumContent::where('curriculum_id',$id)->get();
            $objects  = CurriculumObjective::join('objectives','objective_id','=','objectives.id')->where('curriculum_id',$id)->get();
            $comments  = SchoolCurriculum::query()
                ->where('comment','<>','NULL')
                ->whereNotNull('comment')
                ->where('ecaluation','<>','0')
                ->whereNotNull('ecaluation')
                ->get();
            $flg      = SchoolCurriculum::query()->where('curriculum_id','=',$id)->where('teacher_id','=',$tId)->get();
            return view('teacher.curriculum_content',compact('curriculum','objects','contents','product','flg','comments'));
        }else{
            return $this->index();
        }
    }

    /**
     * カリキュラム追加画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd($id){
        //カリキュラム取得
        $curriculum = Curriculum::find($id);
        if(!empty($curriculum)){
            $teacher = \Auth::user();
            $schoolId = $teacher->school_id;
            //学校の授業時間の時間を取得
            $schoolTimes = SchoolTimeTable::select('*',\DB::raw('TIMEDIFF(end, start) as time'))->where('school_id','=',$schoolId)
                ->orderBy('time_table','asc')->get();

            $times = array();

            //分に変換
            foreach ($schoolTimes as $schoolTime) {
                $time = explode(':',$schoolTime->time);
                $times[$schoolTime->time_table] = array(
                    'time' => $time[0]*60+$time[1],
                    'timetable' => $schoolTime->time_table
                );
            }
            return view('teacher.curriculum_content_add',compact('curriculum','times'));
        }else{
            return $this->index();
        }
    }


    /**
     * 学校の予定にカリキュラムを追加
     * @param CurriculumTableRequest $request
     * @param $curriculum_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postAdd(CurriculumTableRequest $request ,$curriculum_id){
        $teacher = \Auth::user();
        $teacher_id = $teacher->id;

        $times  = $request->time;
        $dates  = $request->date;

        for($i=0;$i<count($times);$i++){
            $school_curriculum = new SchoolCurriculum();
            $school_curriculum->teacher_id    = $teacher_id;
            $school_curriculum->curriculum_id = $curriculum_id;
            $school_curriculum->time_table_id = $times[$i];
            $school_curriculum->year          = date('Y',strtotime('-3 month',time()));
            $school_curriculum->date          = $dates[$i];
            $school_curriculum->save();
        }

        return view('teacher.top');
    }

    /**
     * 商品をクリック時に商品のURLを表示する
     * @param $cId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function productClick($cId){
        $teacher = \Auth::user();
        $tId = $teacher->id;
        //今日の日にちを取得
        $date = date('Y/m/d');
        //カリキュラムの存在チェック
        $cExists = Curriculum::query()->where('id','=',$cId)->exists();
        if($cExists){
            //カリキュラムを取得
            $curriculum = Curriculum::query()->where('id','=',$cId)->get();
            //今日その商品ページに行ったかの記録
            $exists = ProductClick::query()
                ->where('teacher_id','=',$tId)
                ->where('curriculum_id','=',$cId)
                ->where(DB::raw('CAST(`created_at` AS DATE)'),'=',$date)->exists();

            //本日初めてクリックした場合はデータベースに保存
            if(!$exists){
                $pId = $curriculum[0]->product_id;
                $productClick = new ProductClick();
                $productClick->teacher_id    = $tId;
                $productClick->curriculum_id = $cId;
                $productClick->product_id    = $pId;
                $productClick->save();
            }
            //商品情報取得
            $product = Product::query()->where('id','=', $curriculum[0]->product_id)->get();
            //商品URLにリダイレクト
            return redirect($product[0]->url);
        }

        return $this->index();

    }

    public function curriculumDelete(){
        $teacher = \Auth::user();
        $tId = $teacher->id;

        $schoolCurriculums = SchoolCurriculum::query()->where('teacher_id','=',$tId)->get();

        foreach ($schoolCurriculums as $schoolCurriculum){
            $id = $schoolCurriculum->id;
            $curriculum = SchoolCurriculum::find($id);
            $curriculum->delete();
        }

        return $this->index();

    }

    public function comment($id,CommentRequest $request){
        $teacher = \Auth::user();
        $tId     = $teacher->id;
        $curriculums      = SchoolCurriculum::query()
            ->where('curriculum_id','=',$id)
            ->where('teacher_id','=',$tId)->get();
        if(isset($curriculums)){
            $curriculum = SchoolCurriculum::find($curriculums[0]->id);
            $curriculum->comment    = $request->comment;
            $curriculum->ecaluation = $request->evaluation;
            $curriculum->update();
        }
        return redirect('https://homestead.app/teacher/curriculum/'.$id);
    }
}
