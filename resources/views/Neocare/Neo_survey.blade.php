<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="'{{url('public/site_resource/images/incepta.png')}}" type="image/png">

    <title>NeoCare Survey</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{url('public/site_resource/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            background-image: url("{{url('public/site_resource/images/02 b.jpg')}}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%; /* <------ */
            background-position: 50% 0;
            font-weight: bold;
            /*color: #636b6f;*/
            /*font-family: 'Raleway', sans-serif;*/
            /*font-weight: 100;*/
            /*height: 100vh;*/
            /*margin: 0 auto;*/
            /*width: 60%;*/
        }

        /*.container{*/
        /*    padding: 10px;*/
        /*}*/
        hr {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .experience [type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .experience2 [type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .experience3 [type=radio] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* IMAGE STYLES */
        [type=radio] + img {
            cursor: pointer;
        }

        /* CHECKED STYLES */
        [type=radio]:checked + img {
            outline: 2px solid #3071a9;

        }

        .panel-heading {
            background: rgba(122, 130, 136, 0.2) !important;
        }

        .panel-body {
            background: rgba(46, 51, 56, 0.2) !important;
            border-radius: 10px;
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2);
        }

        .panel {
            background: none;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: #DCF0F9;">
    <div class="container text-center">

        <img src="{{url('public/site_resource/images/Neologo.jpg')}}" alt="" width="110px" height="70px">
    </div>
</nav>


<div class="container" style="overflow-y: scroll;height: 100vh;padding-top: 80px">
    <form id="survey_form">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="panel">
                    <div class="panel-body">
                        <p>
                            ১.আপনি কোন সাইজটি ব্যবহার করেছিলেন?
                        </p>

                        <label class="radio-inline"><input type="radio" name="P_SIZE" value="nb">NB</label>

                        <label class="radio-inline"><input type="radio" name="P_SIZE" value="s">S</label>

                        <label class="radio-inline"><input type="radio" name="P_SIZE" value="m">M</label>

                        <label class="radio-inline"><input type="radio" name="P_SIZE" value="l">L</label>

                        <label class="radio-inline"><input type="radio" name="P_SIZE" value="xl">XL</label>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 experience">
                <div class="panel">
                    <div class="panel-body">
                        <p>২.নিওকেয়ার ডায়াপার ব্যবহার করার পর আপনার অভিজ্ঞতা কেমন হয়েছে?
                        </p>

                        <label class="radio-inline" style="padding-left:0px;">
                            ১.<input type="radio" name="experience" value="morehappy">
                            <img src="{{url('public/site_resource/images/040-happy-9.png')}}" width="30px" height="30px">
                        </label>

                        <label class="radio-inline" style="padding-left:0px;">
                            ২.<input type="radio" name="experience" value="happy">
                            <img src="{{url('public/site_resource/images/096-happy-2.png')}}" width="30px" height="30px">
                        </label>

                        <label class="radio-inline" style="padding-left:0px;">
                            ৩.<input type="radio" name="experience" value="straight">
                            <img src="{{url('public/site_resource/images/088-thinking.png')}}" width="30px" height="30px">
                        </label>

                        <label class="radio-inline" style="padding-left:0px;">
                            ৪.<input type="radio" name="experience" value="sad">
                            <img src="{{url('public/site_resource/images/063-sad-2.png')}}" width="30px" height="30px">
                        </label>

                        <label class="radio-inline" style="padding-left:0px;">
                            ৫.<input type="radio" name="experience" value="angry">
                            <img src="{{url('public/site_resource/images/095-angry-1.png')}}" width="30px" height="30px">
                        </label>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 experience2">
                <div class="panel">
                    <div class="panel-body">
                        <p>৩.আপনি কি আপনার পরিচিতদের নিওকেয়ার ব্যবহার করার পরামর্শ দিবেন?
                        </p>

                        <label class="radio-inline" style="padding-left:0px;">
                            ১.<input type="radio" name="suggestion" value="like">
                            <img src="{{url('public/site_resource/images/like23.png')}}" width="30px" height="30px">
                        </label>

                        <label class="radio-inline" style="padding-left:0px;">
                            ২.<input type="radio" name="suggestion" value="dislike">
                            <img src="{{url('public/site_resource/images/finger.png')}}" width="30px" height="30px">
                        </label>

                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 experience3">
                <div class="panel">
                    <div class="panel-body">
                        <p>৪.নিওকেয়ারের কিছু অনন্য ফিচার আছে। এ ব্যাপারে আপনার অনুভুতি কি?
                        </p>
                        <div class="radio">
                            <label style="padding-left:0px;">
                                ১.<input type="radio" name="feature1" value="elasticup">ইলাস্টিক ব্যাক ইয়ার &nbsp;
                                <img src="{{url('public/site_resource/images/like23.png')}}" width="30px" height="30px">&nbsp;
                                &nbsp;
                            </label>
                            <label style="padding-left:0px;">
                                <input type="radio" name="feature1" value="elasticdown">
                                <img src="{{url('public/site_resource/images/finger.png')}}" width="30px" height="30px">
                            </label>

                        </div>
                        <br>
                        <div class="radio">
                            <label style="padding-left:0px;">
                                ২.<input type="radio" name="feature2" value="velcrowup">ভেলক্রো হুক &nbsp;
                                <img src="{{url('public/site_resource/images/like23.png')}}" width="30px" height="30px"> &nbsp;
                                &nbsp;
                            </label>
                            <label style="padding-left:0px;">
                                <input type="radio" name="feature2" value="velcrowdown">
                                <img src="{{url('public/site_resource/images/finger.png')}}" width="30px" height="30px">
                            </label>
                        </div>
                        <br>
                        <div class="radio">
                            <label style="padding-left:0px;">
                                ৩.<input type="radio" name="feature3" value="backsheetup">ব্রিদেবল টেক্সটাইল ব্যাকশীট
                                &nbsp;
                                <img src="{{url('public/site_resource/images/like23.png')}}" width="30px" height="30px"> &nbsp;
                                &nbsp;
                            </label>
                            <label style="padding-left:0px;">
                                <input type="radio" name="feature3" value="backsheetdown">
                                <img src="{{url('public/site_resource/images/finger.png')}}" width="30px" height="30px">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="panel">
                    <div class="panel-body">
                        <p>
                            ৫.নিওকেয়ার এর ট্যাগ লাইন কি?

                            <br>সারারাত আরামে সারাদিন .....................
                        </p>
                        <div class="radio">
                            <label><input type="radio" name="tagline" value="furfure">১. ফুরফুরে</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="tagline" value="jhorjhore">২. ঝরঝরে</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="panel">
                    <div class="panel-body">
                    <span>
                        মোবাইল নম্বরঃ
                    </span>
                        <input class="form-control" type="text" name="mobile" required>


                        <p>
                            মন্তব্যঃ
                        </p>
                        <textarea class="form-control" type="text" name="u_comment"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <button style="padding-top: 10px;" class="btn btn-success btn-block" id = "btnsubmit">
                Submit
            </button>
            <br>
            <p class="text-center"> নিওকেয়ারের সাথে থাকার জন্য ধন্যবাদ।</p>
        </div>



    </form>
</div>
{{Html::script('public/site_resource/js/jquery-2.1.4.min.js')}}
{{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    <script>
        var url_report_output = '{{url('neosurvey')}}';
        $("#btnsubmit").click(function (e) {
            e.preventDefault();

            console.log($('#survey_form').serialize());
            $.ajax({
                method: "POST",
                url: url_report_output,
                data: {
                    _token: '{{csrf_token()}}',
                    param: $('#survey_form').serialize()
                },
                // beforeSend: function () {
                //     $("#loader").show();
                // },
                success: function (data) {
                    console.log(data);
                    if (data.status) {
                        toastr.info(data.status);
                    } else {
                        toastr.info('unable to save record');
                    }

                },
                error: function () {

                },
            complete: function () {
                $("#loader").hide();
            }
            })
            // } else {
            //     alert('please enter required fields');
            // }


        })

    </script>



</body>
</html>
