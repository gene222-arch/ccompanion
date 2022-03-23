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
    <table style="margin-top: 2rem; width: 70%; margin-left: auto;">
        <tr align='right'>
            <th>Course Code</th>
            <th>Subject</th>
            <th>Units</th>
            <th>Final Grade</th>
            <th>Professor</th>
        </tr>
        <tbody>
            @foreach ($schedule->studentGrades as $grade)
                <tr align='right'>
                    <td>{{ $grade->subject->code }}</td>
                    <td>{{ $grade->subject->name }}</td>
                    <td>{{ $grade->subject->units }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $schedule->details->where('subject_id', $grade->subject_id)->first()->professor->name() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top: 3rem;">
        <tbody>
            <tr>
                <td>Total units</td>
                <td align='right'><strong>{{ $totalUnits }}</strong></td>
            </tr>
            <tr>
                <td>Total Units Passed</td>
                <td align='right'><strong>{{ $totalUnitsPassed }}</strong></td>
            </tr>
            <tr>
                <td>Total Units Failed</td>
                <td align='right'><strong>{{ $totalUnitsFailed }}</strong></td>
            </tr>
            <tr>
                <td>Total Units INC</td>
                <td align='right'><strong>{{ $totalUnitsINC }}</strong></td>
            </tr>
            <tr>
                <td>Status</td>
                <td align='right'>
                    <strong>{{ $status }}</strong>    
                </td>
            </tr>
            <tr>
                <td>G.W.A</td>
                <td align='right'>
                    <strong>{{ number_format($schedule->student_grades_avg_grade_point_equivalence, 2) }}</strong>    
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>