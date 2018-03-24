<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\School;
use App\SchoolCurriculum;
use App\TeacherAccount;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use App\SchoolTimeTable;

class IndexController extends Controller
{
    public function index()
    {
        $school = \Auth::user();
        $sId     = $school->id;

        //教師が登録したカリキュラムの新着情報
        $newses = School::query()
            ->select('teacher_accounts.name','title','date','time_table_id','school_curriculums.updated_at')
            ->join('teacher_accounts','teacher_accounts.school_id','=','schools.id')
            ->join('school_curriculums','school_curriculums.teacher_id','=','teacher_accounts.id')
            ->join('curriculums','curriculums.id','=','school_curriculums.curriculum_id')
            ->where('schools.id','=',$sId)
            ->orderBy('school_curriculums.updated_at','desc')->get();

        //学校の先生情報取得
        $teachers = TeacherAccount::query()->where('teacher_accounts.school_id','=',$sId)
            ->select(\DB::raw('count(school_curriculums.id) as num,teacher_accounts.*,school_grade,class_name'))
            ->leftJoin('school_curriculums',function ($join) {
                $join->on('school_curriculums.teacher_id','=','teacher_accounts.id')
                    ->where('school_curriculums.year','=',date('Y',strtotime('-3 month',time())));
            })
            ->leftJoin('teacher_classes',function ($join){
                $join->on('teacher_classes.teacher_id','=','teacher_accounts.id')
                    ->where('teacher_classes.year','=',date('Y',strtotime('-3 month',time())));
            })
            ->whereNull('deleted_at')
            ->groupBy('teacher_accounts.id','teacher_classes.id')
            ->get();

        return view('school.top',compact('teachers','newses'));
    }
}
