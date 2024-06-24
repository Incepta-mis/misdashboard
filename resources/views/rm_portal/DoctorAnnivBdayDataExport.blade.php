<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Doctor Event Data</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Sl.</th>
        <th>Doctor Id</th>
        <th>Doctor Name</th>
        <th>Doctor Address</th>
        <th>Territory</th>
        <th>Email Id</th>
        <th>Mobile No</th>
        <th>{{$event}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rdata as $r)
        <tr>
            <td>{{$loop->index + 1}}</td>
            <td>{{$r->doctor_id}}</td>
            <td>{{$r->doctor_name}}</td>
            <td>{{$r->doctor_address}}</td>
            <td>{{$r->territory}}</td>
            <td>{{$r->email_id}}</td>
            <td>{{$r->mobile_no}}</td>
            <td>{{$r->event_date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
