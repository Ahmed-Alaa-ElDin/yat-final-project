@extends('layouts.master')

@section('title')
    Drug Market | View Users    
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Statistics
          <small>View</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
            <div class="d-block m-auto">
                <h4 class="text-center m-3">New Registered User / Day</h4>
                <canvas id="creation_date" width="400" height="400"></canvas>
            </div>
            <hr>
            <div class="d-block m-auto">
                <h4 class="text-center m-3">Top 10 Visitors</h4>
                <canvas id="top_ten" width="400" height="400"></canvas>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <script>
        var myCanv = document.getElementById('creation_date');
        var topTenCanv = document.getElementById('top_ten');
        
        var myChart = new Chart(myCanv, {
            type: 'line',
            data: {
                labels: [
                    '2021-01-01'
                    @foreach ($stats as $stat)
                        ,'{{$stat->date}}'
                    @endforeach
                    ],
                
                datasets: [{
                    label: 'New User / Day',
                    data: [
                        0
                        @foreach ($stats as $stat)
                            ,'{{$stat->number}}'
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        @foreach ($stats as $stat)
                            ,'rgba(255, 99, 132, 0.2)'
                        @endforeach
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'
                        @foreach ($stats as $stat)
                            ,'rgba(255, 99, 132, 1)'
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                },
                aspectRatio: 1,
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
        
        var topTenChart = new Chart(topTenCanv, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($top as $top_p)
                        '{{$top_p->first_name}} {{$top_p->last_name}}',
                    @endforeach
                    ],
                
                datasets: [{
                    data: [
                        @foreach ($top as $top_p)
                            '{{$top_p->visit_number}}',
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 32, 45, 0.2)',
                        'rgba(35, 56, 255, 0.2)',
                        'rgba(153, 255, 123, 0.2)',
                        'rgba(35, 255, 102, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 32, 45, 1)',
                        'rgba(35, 56, 255, 1)',
                        'rgba(153, 255, 123, 1)',
                        'rgba(35, 255, 102, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                },
                aspectRatio: 1,
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                    label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                    }
                    }
                }
            }
        });


        myChart.canvas.parentNode.style.height = '48%';
        myChart.canvas.parentNode.style.width = '48%';
        topTenChart.canvas.parentNode.style.width = '48%';
        topTenChart.canvas.parentNode.style.width = '48%';



    </script>

@endsection
