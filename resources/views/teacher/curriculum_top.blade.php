@extends('teacher.layout')

@section('content')
    @foreach($curriculumList as $key=>$curriculums )
        <div id="curriculum{{$key}}" class="col s12 row">
            @foreach($curriculums as $curriculum)
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="{{{$curriculum->curriculum_image}}}">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">{{$curriculum->title}}<i class="material-icons right">more_vert</i></span>
                            <p><a href="/teacher/curriculum/{{$curriculum->id}}">詳細へ</a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">{{$curriculum->title}}<i class="material-icons right">close</i></span>
                            <p>{{$curriculum->description}}</p>
                        </div>
                    </div>
                </div>
                @if($loop->iteration >= 3)
                    @break
                @endif
                @endforeach
        </div>
    @endforeach
@endsection