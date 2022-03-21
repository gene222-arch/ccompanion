@extends('layouts.main')

@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        let monthlyActivities = {!! json_encode($monthlyActivities) !!};
        let monthlyActivitydata = [ ...monthlyActivities ];
        let monthlyRegisteredStudents = {!! json_encode($monthlyRegisteredStudents) !!};
        let monthlyRegisteredStudentdata = [ ...monthlyRegisteredStudents ];

        const highestActivityCount = monthlyActivities.sort()[monthlyActivities.length - 1];

        monthlyActivitydata = monthlyActivitydata
            .map((activityCount, index) => (activityCount === highestActivityCount) 
                ? ({
                        y: activityCount,
                        marker: {
                            symbol: 'url(https://www.kindpng.com/picc/m/714-7141386_music-activity-a-transparent-activities-icon-png-png.png)',
                            width: 40,
                            height: 40
                        }
                })
                : activityCount
            );

        const highestRegisteredCount = monthlyRegisteredStudents.sort()[monthlyRegisteredStudents.length - 1];

        monthlyRegisteredStudentdata = monthlyRegisteredStudentdata
            .map((studentCount, index) => (studentCount === highestRegisteredCount) 
                ? ({
                        y: studentCount,
                        marker: {
                            symbol: 'url(https://www.pikpng.com/pngl/m/303-3034902_student-enrollment-icon-clipart.png)',
                            width: 40,
                            height: 40
                        }
                })
                : studentCount
            );

        Highcharts.chart('monthlyActivities', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Monthly Audit Trails'
            },
            xAxis: {
                categories: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ]
            },
            yAxis: {
                title: {
                    text: 'Activity Count'
                },
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
                name: 'Activities',
                marker: {
                    symbol: 'square'
                },
                data: monthlyActivitydata
            }]
        });

        Highcharts.chart('monthlyRegisteredStudents', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Monthly Registered Students'
            },
            xAxis: {
                categories: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ]
            },
            yAxis: {
                title: {
                    text: 'Registered Count'
                },
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
                name: 'Students',
                marker: {
                    symbol: 'square'
                },
                data: monthlyRegisteredStudentdata
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
        <div class="col-12 col-sm-12 col-md-10 mt-5">
            <div class="row">
                <div class="col-12 col-sm-12" style="display: {{ $userCanViewMontlyActivities ? 'block' : 'none' }}">
                    <div class="card p-2 border-info">
                        <div id="monthlyActivities"></div>
                    </div>
                </div>
                <hr class="2 my-5">
                <div 
                    class="col-12 col-sm-12" 
                    style="display: {{ $userCanViewMonthlyRegisteredStudents ? 'block' : 'none' }}"
                >
                    <div class="card p-2 border-info">
                        <div id="monthlyRegisteredStudents"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
