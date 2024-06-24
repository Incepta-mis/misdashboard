
{{--<img src="//192.168.1.221/ExpenseImage/exp10066831508658215851/travelAllowanceImage.jpg" alt="image">--}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    {{--<link rel="stylesheet" href="viewer.css">--}}
    {{--<link rel="stylesheet" href="css/bootstrap.min.css">--}}

</head>
<body>
<center style="margin-top: 30px;">
    <!-- a block container is required -->
    <div>
        <img class="image" height="600px" width="600px" alt="Picture">

        <input type="hidden" value="<?php echo $uid;?>" id="uid">
        <input type="hidden" value="<?php echo $imagetype;?>" id="typeimgnameid">
        <input type="hidden" value="<?php echo $up_status;?>" id="up_id">

    </div>

</center>
{{Html::script('public/site_resource/js/jquery-2.1.4.min.js')}}
{{Html::script('public/site_resource/js/bootstrap.min.js')}}
{{--<script src="js/bootstrap.min.js"></script>--}}
{{--<script src="viewer.js"></script>--}}
<script type="text/javascript">
    $(document).ready(function () {

        var id=$("#uid").val();
        console.log(id);
        var imgname=$("#typeimgnameid").val();
        console.log(imgname);

        var up_id=$("#up_id").val();
        console.log(up_id);
        var url;


        if(up_id=='yes'){
//            $('.image').attr('src','//192.168.1.221/ExpenseImage/'+id+'/'+imgname);
//            url=public_path('/ExpenseImage/')+id+'/'+imgname;
            var urlparam = '/'+id+'/'+imgname;
            var mainurl = "{{URL::to("ExpenseImage")}}"+urlparam;
            console.log(mainurl);
            $('.image').attr('src',mainurl);
        }else{
            var urlparam = '/'+id+'/'+imgname;
            var mainurl = "http://192.168.1.13:5023/ExpenseImage"+urlparam;
            console.log(mainurl);
            $('.image').attr('src',mainurl);
        }

    });
</script>
</body>
</html>