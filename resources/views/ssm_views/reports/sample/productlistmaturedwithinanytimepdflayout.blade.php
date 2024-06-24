<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List Matured Within AnyTime</title>
</head>
<body>
<table>
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Product Name</th>
        <th>Batch Number</th>
        <th>Kept on date</th>
        <th>Pulling Date</th>
        <th>Pulling Time Point</th>
        <th>Chamber ID</th>
        <th>Chamber Storage Location</th>
        <th>Chamber Storage Condition</th>
        <th>Initial sample Qty</th>
        <th>Remaining Sample Qty</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pdata1 as  $s)
        <tr>

            <td style="text-align: center">{{$loop->index+1}}</td>
            <td>{{$s->pname}}</td>
            <td  style="text-align: center">{{$s->batch_number}}</td>
            <td>{{$s->kept_on_date}}</td>
            <td>{{$s->pulling_date}}</td>
            <td>{{$s->pulling_time_point}}</td>
            <td>{{$s->chamber_id}}</td>
            <td  style="text-align: center">{{$s->chamber_stor_loc}}</td>
            <td  style="text-align: center">{{$s->chamber_stor_cond}}</td>
            <td  style="text-align: center">{{$s->initial_sample_qty}}</td>
            <td  style="text-align: center">{{$s->rem_sample_qty}}</td>
            <td>{{$s->remarks}}</td>
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