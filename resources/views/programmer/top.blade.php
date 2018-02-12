@extends('programmer.layout')

@section('layout_js')
    <script type="text/javascript" src="{{{'/js/chart/Chart.min.js'}}}"></script>
    <script type="text/javascript" src="{{{'/js/programmer/chart.js'}}}"></script>

@endsection
@section('content')
    <div class="main">
        <h2>１日毎の報酬集計(円)</h2>
        <div class="button_group">
            <button data-date="year" class="left-button">年</button>
            <button data-date="month">月</button>
            <button data-date="day" id="active_button" class="right-button">日</button>
        </div>
        <canvas id="myChart"></canvas>
        <script>
            $(function() {
                var data = {!! $data !!};
                var labels = {!! $labels !!};
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type : 'bar',
                    data: {
                        labels: labels,
                        datasets:[{
                            label:"１日毎の報酬集計(円)",
                            fill :false,
                            pointBackgroundColor:'rgb(238, 110, 115)',
                            pointRadius:5,
                            borderColor: "rgb(238, 110, 115)",//線の色
                            data : data ,
                        }]
                    },
                    options:{
                        scales:{
                            yAxes:[{
                                ticks: {
                                    beginAtZero: true,
                                    min:0,
                                }
                            }]
                        }
                    }
                });

                $('.button_group button').on('click',function() {
                    var date = $(this);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/programmer/chart/ajax',
                        type: 'POST',
                        data:{
                            'date':$(this).data('date')
                        }
                    })
                        .done(function(data) {
                            labels = data['labels'];
                            var ctx = document.getElementById('myChart').getContext('2d');
                            myChart.destroy();
                            myChart = new Chart(ctx, {
                                type : 'bar',
                                data: {
                                    labels:data['labels'],
                                    datasets:[{
                                        pointRadius:5,
                                        data :data['datasets']['data'],
                                        label:data['datasets']['label'],
                                        fill :false,
                                        borderColor:'rgb(238, 110, 115)',
                                        pointBackgroundColor:'rgb(238, 110, 115)'
                                    }]
                                },
                                options:{
                                    scales:{
                                        yAxes:[{
                                            ticks: {
                                                beginAtZero: true,
                                                min:0,
                                            }
                                        }]
                                    }
                                }
                            });
                            $('.button_group button').removeAttr('id');
                            $(date).attr('id','active_button');
                            $('h2').text(data['datasets']['label']);
                        })
                        .fail(function(data) {
                            $('.result').html(data);
                        });
                })
            });
        </script>
    </div>
@endsection