<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif
        }
    </style>
</head>
<body>
    <p align='right' style="margin-bottom: 1rem;">SN: <i style="color: gray;">{{ $serialCode->code }}</i></p>
    <table>
        <tbody>
            <tr>
                <td><strong>Course</strong></td>
                <td>{{ $schedule->course->code }}</td>
            </tr>
            <tr>
                <td><strong>Major</strong></td>
                <td>XXX-CCC-XXX</td>
            </tr>
            <tr>
                <td><strong>Level</strong></td>
                <td>{{ $schedule->year_level }}</td>
            </tr>
        </tbody>
    </table>
    <table style="margin-top: 1rem">
        <tbody>
            <tr>
                <td><strong>ID No:</strong></td>
                <td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td><strong>Student Name:</strong></td>
                <td>{{ $student->user->name }}</td>
            </tr>
        </tbody>
    </table>
    <table style="margin-top: 2rem;">
        <tr>
            <th></th>
            <th>Subject</th>
            <th>Section</th>
            <th>Room</th>
            <th>Time</th>
            <th>Day</th>
            <th>Professor</th>
            <th>Units</th>
        </tr>
        <tbody>
            @foreach ($schedules as $subject => $scheduleDetails)
                <tr>
                    <td>{{ $subject }}</td>
                    <td>{{ $scheduleDetails['name'] }}</td>
                    <td>{{ $scheduleDetails['section'] }}</td>
                    <td>{{ $scheduleDetails['room'] }}</td>
                    <td>{{ $scheduleDetails['time'] }}</td>
                    <td>{{ $scheduleDetails['day'] }}</td>
                    <td>{{ $scheduleDetails['professor'] }}</td>
                    <td>{{ $scheduleDetails['units'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>