<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Print Report</title>
</head>
<body>

<table>
    <tr>
        <td></td>
        <td></td>

        <td></td>
    </tr>

    <tr>
        <td style="font-size: 1.3rem;" colspan="5"><b><span
                        style="text-align: center;"><h1>Incepta Pharmaceuticals Ltd.</h1></span></b></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-size: 30px;" colspan="5"><b><span
                        style="text-align: center;"><h2>Print Report of Issued Document</h2></span></b></td>
        <td></td>

        <td></td>

    </tr>
</table>

<table border="1">
    <thead>
    <tr style="border: 1px solid #000000;">
        <th style="text-align: center;">Print Date Time</th>
        <th style="text-align: center;">File Name</th>
        <th style="text-align: center;">Printed By</th>
        <th style="text-align: center;">Print Type</th>
        <th style="text-align: center;">Remark</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pdata as $d)
        <tr>
            <td>{{$d->print_dt}}</td>
            <td>{{$d->file_name}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->print_type}}</td>
            <td>{{$d->reason}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>

<br>
<table>
    <tr>
        <td>Printed by: {{\Illuminate\Support\Facades\Auth::user()->name}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>

</body>
</html>