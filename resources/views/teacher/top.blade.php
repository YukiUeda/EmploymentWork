@extends('teacher.layout_top')

@section('top_js')
    <script type="text/javascript" src="{{{'/js/moment.min.js'}}}"></script>
    <script type="text/javascript" src="{{{'/js/fullcalendar.min.js'}}}"></script>
    <script type="text/javascript" src="{{{'/js/ja.js'}}}"></script>

@endsection
@section('content')
    <script>

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                defaultView: 'agendaWeek',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: new Date(),
                events:'/teacher/calender'
            });
        });

    </script>
    <div id='calendar'></div>
@endsection