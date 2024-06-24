<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear {{$user->name}},</p>
    <p>Your request for booking the dormitory has been approved and updated.</p>
    <p>Updated Event Information - </p>
    <p>Room No. : {{$book[0]->room_id}}</p>
    <p>Event Start Time : {{\Carbon\Carbon::parse($book[0]->start_time)->format('d-M-Y, h:i A')}}</p>
    <p>Event End Time : {{\Carbon\Carbon::parse($book[0]->end_time)->format('d-M-Y, h:i A')}}</p>
<br>
<p>Best Regards</p>
{{$user->name}}
</body>
</html>