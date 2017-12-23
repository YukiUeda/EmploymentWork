<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SchoolTimeTable;

class TimeCreateController extends Controller
{
    public function index()
    {
        $school = \Auth::user();
        $id = $school->id;
        $name = $school->name;
        $time_table = new SchoolTimeTable;
        $table = $time_table::query()->where('school_id',$id)->get();
        return view('school.classworkTimer',compact('table','name'));
    }

    public function create(Request $request){
        //現在ログインしているユーザのインスタンス
        $school = \Auth::user();
        //現在ログインしているユーザのid
        $id = $school->id;
        //入力された時間割を6限目まで回す
        for($i=1; $i <= 6; $i++){
            //終了時間と開始時間を取得
            $time_str = $request->input('lesson'.$i.'_str');
            $time_end = $request->input('lesson'.$i.'_end');
            //終了時間と開始時間がないと以降の処理を中断
            if($time_str===null || $time_end===null){
                break;
            }

            //検索ようインスタンス生成
            $time_table = new SchoolTimeTable;
            //ユーザID設定
            $time_table->school_id = $id;
            //何限目かの設定
            $time_table->time_table=$i;
            //ユーザが$i限目を登録されてるのを取得
            $table = $time_table::query()->where('school_id',$id)->where('time_table',$i)->get();
            //$i限目の存在チェック
            if(count($table)===0){
                //存在していないとINSERT文発行
                $time_table->start = $time_str;
                $time_table->end = $time_end;
                $time_table->save();
            }else{
                //存在しているとUPDATE文発行
                $update = SchoolTimeTable::find($table[0]['id']);
                $update->start =  $time_str;
                $update->end =  $time_end;
                $update->update();
            }
        }
        return $this->index();
    }
}
