
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        table, th, td {
            border: 1px solid gray;
            border-collapse: collapse;
            color:  #343434;
            font-size: 13px;
            padding: 13px;
        }
        th{
            font-weight: bold;
            text-align: left;
        }
        .text_style{
            font-size: 15px;
            color: #0076CE;
            font-family: Arial;
        }
    </style>
</head>
<body>
<p class="text_style">Dear Sir/Madam,</p>
<p class="text_style">Please receive the <strong>absenteeism</strong> information of the following employee,</p>
<br>


<p class="text_style">The details are as follows, </p>
<table style="width:100%">
    <tr>
        <th>EMP ID</th>
        <th>NAME</th>
        <th>DESIGNATION</th>
        <th>DEPARTMENT</th>
        <th>SECTION</th>
        <th>WORK CENTER ID</th>
        <th>FROM</th>
        <th>TO</th>
        <th>TOTAL DAYS</th>
        <th>STATUS</th>
        <th>REASON TYPE</th>
        <th>REASON BY EMPLOYEE</th>
        <th>REASON ACCEPTABILITY</th>
    </tr>
    <tr>
        <td>{{$emp_id}}</td>
        <td>{{$emp_name}}</td>
        <td>{{$emp_deg}}</td>
        <td>{{$emp_dept}}</td>
        <td>{{$emp_sec}}</td>
        <td>{{$wc}}</td>
        <td>{{$date_from}}</td>
        <td>{{$date_to}}</td>
        <td>{{$absence_days}}</td>
        <td>{{$status}}</td>
        <td>{{$reason_type}}</td>
        <td>{{$reason_by_emp}}</td>
        <td>{{$reason_acceptability}}</td>
    </tr>
</table>

<br>
<p class="text_style">Thanks You</p>
<span class="text_style">With Regard,</span>
<br>

<span class="text_style">{{$uid}}</span>
<br>
<span class="text_style">{{$user_name}}</span>
<br>
<span class="text_style">{{$user_designation}},{{$user_dept}}</span>

</body>
</html>