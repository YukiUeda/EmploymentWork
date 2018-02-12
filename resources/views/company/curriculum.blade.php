@extends('company.layout')

@section('layout_css')
@endsection

@section('layout_js')
@endsection

@section('content')
    <table class="striped">
        <thead>
        <tr>
            <th>画像</th>
            <th>カリキュラム名</th>
            <th>商品名</th>
            <th>科目</th>
            <th>認証状況</th>
            <th>詳細</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($curriculums as $curriculum)
            <tr>
                <td><img style="height: 50px;" src="{{{$curriculum->curriculum_image}}}"></td>
                <td>{{$curriculum->title}}</td>
                <td>{{$curriculum->name}}</td>
                <td>{{Config::get('const.curriculum')[$curriculum->subject]}}</td>
                @if($curriculum->auth == 0)
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ff2600" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                            <path d="M0 0h24v24H0z" fill="none"/>
                        </svg>
                        <label>未承認</label>
                    </td>
                @else
                    <td>
                        <svg fill="#4fe023" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <label>承認済</label>
                    </td>
                @endif
                <td><a href="/company/curriculum/{{$curriculum->id}}"><button>表示</button></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $curriculums->links('vendor.pagination.foundation') }}

@endsection