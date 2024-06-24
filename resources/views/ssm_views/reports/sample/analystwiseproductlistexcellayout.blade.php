<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analyst Wise Product List</title>
</head>
<body>
<table>
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Product Name</th>
        <th>Batch Number</th>
        <th>Analyst name</th>
        <th>Kept On Date</th>
        <th>Time point </th>
        <th>Chamber Storage Condition</th>
        <th>Stability Type</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pdata1 as  $s)
        <tr>

            <td style="text-align: center">{{$loop->index+1}}</td>
            <td>{{$s->pname}}</td>
            <td  style="text-align: center">{{$s->batch_number}}</td>
            <td>{{$s->analyst_name}}</td>
            <td  style="text-align: center">{{$s->kept_on_date}}</td>
            <td  style="text-align: center">{{$s->time_point}}</td>
            <td>{{$s->chamber_stor_cond}}</td>
            <td  style="text-align: center">{{$s->stab_type}}</td>
        </tr>

    @endforeach

    </tbody>
    <tfoot>

    <tr style="text-align: center;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>