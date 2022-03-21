@extends('layouts.main')

@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
           Highcharts.chart('container', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Monthly Average Temperature'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature'
            },
            labels: {
                formatter: function () {
                    return this.value + '°';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Tokyo',
            marker: {
                symbol: 'square'
            },
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, {
                y: 26.5,
                marker: {
                    symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)'
                }
            }, 23.3, 18.3, 13.9, 9.6]

        }, {
            name: 'London',
            marker: {
                symbol: 'diamond'
            },
            data: [{
                y: 3.9,
                marker: {
                    symbol: 'url(https://www.highcharts.com/samples/graphics/snow.png)'
                }
            }, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
    </script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @hasrole('Super Administrator')
            <div class="col-12 col-sm-12 col-md-4">
                <div class="card bg-secondary">
                    <div class="card-body text-center">
                        <div class="card-title text-light">Administrators</div>
                        <h1 class="my-4 text-warning">{{ $administratorCount }}</h1>
                        <i class="fa-solid fa-user-shield text-light fa-2x"></i>
                    </div>
                </div>
            </div>
        @endhasrole
        @hasanyrole('Super Administrator|Administrator')
            <div class="col-12 col-sm-12 col-md-4">
                <div class="card bg-info">
                    <div class="card-body text-center">
                        <div class="card-title text-light">Registrars</div>
                        <h1 class="my-4 text-warning">{{ $registrarCount }}</h1>
                        <i class="fa-solid fa-user-tie text-light fa-2x"></i>
                    </div>
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('Super Administrator|Administrator|Registrar')
            <div class="col-12 col-sm-12 col-md-4 mb-5">
                <div class="card bg-success">
                    <div class="card-body text-center">
                        <div class="card-title text-light">Students</div>
                        <h1 class="my-4 text-warning">{{ $studentCount }}</h1>
                        <i class="fa-solid fa-user text-light fa-2x"></i>
                    </div>
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('Super Administrator|Administrator|Registrar')
            <div class="col-12 col-sm-12 col-md-4 mb-5">
                <div class="card bg-danger">
                    <div class="card-body text-center">
                        <div class="card-title text-light">Courses</div>
                        <h1 class="my-4 text-warning">{{ $courseCount }}</h1>
                        <i class="fa-solid fa-graduation-cap text-light fa-2x"></i>
                    </div>
                </div>
            </div>
        @endhasanyrole
        <div class="col-12 mt-5">
            <div id="container"></div>
        </div>
    </div>
</div>
@endsection
