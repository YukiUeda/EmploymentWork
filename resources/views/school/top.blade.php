@extends('school.layout')

@section('content')
    <div  class="row">
        <div class="col s12">
            <h2>新着ニュース</h2>
            <div class="card-panel">
                <div class="row">
                    @foreach($newses as $news)
                        <div class="col s12">
                            <p class="col s2">{{$news->updated_at}}</p>
                            <p class="col s10">{{$news->name}}先生が{{$news->title}}を{{$news->date}}の{{$news->time_table_id}}時限目に登録しました。</p>
                        </div>
                        @if(3 < $loop->count)
                            @break
                        @endif
                    @endforeach
                </div>
            </div>

            <h2>所属教師</h2>
            <table class="highlight">
                <thead>
                <tr>
                    <th>名前</th>
                    <th>担当クラス</th>
                    <th>カリキュラム登録数</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>{{$teacher->name}}</td>
                        <td>{{isset($teacher->class_name) ? $teacher->school_grade.'年'.$teacher->class_name.'組' : '担当クラスなし'}}</td>
                        <td>{{$teacher->num}}時間</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection