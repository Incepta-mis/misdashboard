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
<p>Your request for booking the dormitory has been rejected.</p>
<br>
<p>Best Regards</p>
{{$user -> user}}
</body>
</html>