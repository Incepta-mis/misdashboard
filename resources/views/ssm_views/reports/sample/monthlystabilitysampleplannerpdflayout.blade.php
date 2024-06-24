<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly S.S.Planner</title>
</head>
<body>
<table border="1" style="border-collapse: collapse">
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Product Name</th>
        <th>Batch Number</th>
        <th>Test Duration</th>
        <th>Kept on date</th>
        <th>Condition: 30⁰C+65% RH</th>
        <th>Condition: 30⁰C+75% RH</th>
        <th>Condition: 40⁰C+75% RH</th>
        <th>Condition: 25⁰C+60% RH</th>
        <th>Condition: 2⁰C+8⁰C</th>
        <th>Sample Per Test</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pdata1 as  $s)
        <tr>
            <td style="text-align: center">{{$loop->index+1}}</td>
            <td>{{$s->pname}}</td>
            <td  style="text-align: center">{{$s->batch_number}}</td>
            <td  style="text-align: center">{{$s->test_duration}}</td>
            <td>{{$s->kept_on_date}}</td>
            <td  style="text-align: center">{{$s->a3065}}</td>
            <td  style="text-align: center">{{$s->b3075}}</td>
            <td  style="text-align: center">{{$s->c4075}}</td>
            <td  style="text-align: center">{{$s->d2560}}</td>
            <td  style="text-align: center">{{$s->e53}}</td>
            <td  style="text-align: center">{{$s->sample_qc_test}}</td>

        </tr>

    @endforeach

    </tbody>
</table>
</body>
</html>