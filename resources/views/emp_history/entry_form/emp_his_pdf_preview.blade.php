<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee's Personal History Form</title>
    <style>

        .textcntr {
            text-align: center;
            font-size: 11px;
        }

        /*---------BOOTSTRAP STYLES----------*/

        /*.row {*/
        /*margin-right: -15px;*/
        /*margin-left: -15px;*/
        /*}*/

        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 0px;
            padding-left: 0px;
        }

        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }

        .col-xs-12 {
            width: 100%;
        }

        .col-xs-11 {
            width: 91.66666667%;
        }

        .col-xs-10 {
            width: 83.33333333%;
        }

        .col-xs-9 {
            width: 75%;
        }

        .col-xs-8 {
            width: 66.66666667%;
        }

        .col-xs-7 {
            width: 58.33333333%;
        }

        .col-xs-6 {
            width: 50%;
        }

        .col-xs-5 {
            width: 41.66666667%;
        }

        .col-xs-4 {
            width: 33.33333333%;
        }

        .col-xs-3 {
            width: 25%;
        }

        .col-xs-2 {
            width: 16.66666667%;
        }

        .col-xs-1 {
            width: 8.33333333%;
        }

        .col-xs-pull-12 {
            right: 100%;
        }

        .col-xs-pull-11 {
            right: 91.66666667%;
        }

        .col-xs-pull-10 {
            right: 83.33333333%;
        }

        .col-xs-pull-9 {
            right: 75%;
        }

        .col-xs-pull-8 {
            right: 66.66666667%;
        }

        .col-xs-pull-7 {
            right: 58.33333333%;
        }

        .col-xs-pull-6 {
            right: 50%;
        }

        .col-xs-pull-5 {
            right: 41.66666667%;
        }

        .col-xs-pull-4 {
            right: 33.33333333%;
        }

        .col-xs-pull-3 {
            right: 25%;
        }

        .col-xs-pull-2 {
            right: 16.66666667%;
        }

        .col-xs-pull-1 {
            right: 8.33333333%;
        }

        .col-xs-pull-0 {
            right: 0;
        }

        .col-xs-push-12 {
            left: 100%;
        }

        .col-xs-push-11 {
            left: 91.66666667%;
        }

        .col-xs-push-10 {
            left: 83.33333333%;
        }

        .col-xs-push-9 {
            left: 75%;
        }

        .col-xs-push-8 {
            left: 66.66666667%;
        }

        .col-xs-push-7 {
            left: 58.33333333%;
        }

        .col-xs-push-6 {
            left: 50%;
        }

        .col-xs-push-5 {
            left: 41.66666667%;
        }

        .col-xs-push-4 {
            left: 33.33333333%;
        }

        .col-xs-push-3 {
            left: 25%;
        }

        .col-xs-push-2 {
            left: 16.66666667%;
        }

        .col-xs-push-1 {
            left: 8.33333333%;
        }

        .col-xs-push-0 {
            left: 0;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }

        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }

        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }

        .col-xs-offset-9 {
            margin-left: 75%;
        }

        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }

        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }

        .col-xs-offset-6 {
            margin-left: 50%;
        }

        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        .col-xs-offset-3 {
            margin-left: 25%;
        }

        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }

        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }

        .col-xs-cusoffset-1 {
            margin-left: 7.33333333%;
        }

        .col-xs-offset-0 {
            margin-left: 0;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }

        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }

        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }

        .col-xs-offset-9 {
            margin-left: 75%;
        }

        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }

        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }

        .col-xs-offset-6 {
            margin-left: 50%;
        }

        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        .col-xs-offset-3 {
            margin-left: 25%;
        }

        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }

        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }

        .col-xs-offset-0 {
            margin-left: 0;
        }

        table {
            max-width: 100%;
            background-color: transparent;
        }

        table {
            border-collapse: collapse;

        }

        table th {
            /*border: 1px solid black;*/
            padding: 2px;
            text-align: center;
        }

        .row:before,
        .row:after {
            display: table;
            content: " ";
            clear: both;
        }

        /*--------End BStyles------------- */


        .table > thead > tr > th,
        .table > tbody > tr > td {
            padding: 2px;
            color: #000000;
        }

        /*.table_edu> thead > tr > th,*/
        /*.table_edu > tbody > tr > td {*/
        /*border: 1px solid black;*/

        /*}*/
        .education_table > thead > tr > th {
            padding: 4px;
            border: 1px solid black;
            font-size: 14px;
        }

        .education_table > tbody > tr > td {

            border: 1px solid black;
            font-size: 13px;
            padding: 4px;
        }

        .lang_table > thead > tr > th {
            padding: 4px;
            border: 1px solid black;
            font-size: 14px;
        }

        .lang_table > tbody > tr > td {

            border: 1px solid black;
            font-size: 13px;
            padding: 4px;
        }

        .d_sig_table > thead > tr > th {
            padding: 4px;
            font-size: 14px;
        }

        .d_sig_table > tbody > tr > td {


            font-size: 13px;
            padding: 4px;
        }


        #footer {
            position: absolute;
            bottom: 0px;
            /*width:100%;*/
            font-size: 13px;
            font-family: "Times New Roman";
        }


        @page {
            margin: 0cm 0cm 0cm 0cm;
        }

        .ud {
            border-bottom: 1px dotted #000;
            /*font-weight: bold;*/
            text-decoration: none;
        }

        body {
            font-size: 14px;
            font-family: "Times New Roman";
            margin-top: 2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        .amt {
            text-align: right;
        }

        #content {
            position: relative;
        }

        #content img {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        [type="checkbox"] {
            vertical-align: middle;
        }

        .tablebasic tr.th {
            font-size: 13px;
        }

        .textdot {
            border-bottom: 1px dotted #000;
            text-decoration: none;
        }

        .brtb {
            border: 1px solid black;
        }

        .rowref {
            /*display: flex; !* equal height of the children *!*/
            page-break-inside: auto;
        }

        /*.colref {*/
        /*    flex: 1; !* additionally, equal width *!*/

        /*    padding: 1em;*/
        /*    !*border: solid;*!*/
        /*}*/

        .capitalize {
            text-transform: capitalize;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>
<body>

{{--main body start--}}
{{--<div class="row">--}}
{{----}}
{{--</div>--}}
<div class="row" style="margin-top:35px">
    <span style="color:red">(Preview Version)</span>
    <br>
    <table class="tableintro tableborder" width="100%" style="border:1px solid black;">
        <thead>
        <tr style="border:1px solid black;margin-top: 10px">
            <th style="text-align: left;padding-left: 3px;">
                <table class="tableintro tableborder" width="100%">
                    <tr style="border:1px solid black;margin-top: 10px">
                        <th style="border-right: 1px solid black">
                            <span style="font-size: 12px;"><b><u>Instruction</u></b></span> <br>
                            <span style="font-size: 11px;font-weight:normal">Please attempt each portion <br>
                clearly completely and <br>
                concisely
                </span>
                        </th>
                        <th id="content" width="70px">
                            <?php
                            $path_incep = url('public/site_resource/images/incepta.png');
                            $type_incep = pathinfo($path_incep, PATHINFO_EXTENSION);
                            $data_incep = file_get_contents($path_incep);
                            $base64_incep = 'data:image/' . $type_incep . ';base64,' . base64_encode($data_incep);
                            ?>
                            <img src="{{$base64_incep}}" width="70px" height="50px">

                        </th>
                        <th colspan="4">
                            <span style="font-size: 13px;"><b> INCEPTA</b> <br>
                                <br><b>EMPLOYEE'S PERSONAL HISTORY FORM</b>
                                <br>
                            </span>
                        </th>
                    </tr>
                    <br>
                    <tr style="border-top: 1px solid black">
                        <th style="border-top: 1px solid black">Application Source
                            <br>(Optional)
                        </th>
                        <th colspan="5" style="text-align: left;border-top: 1px solid black">

                            @if(count($emp_his_moreinfoid[0]->app_source))

                                <label style="word-wrap:break-word">
                                    <input type="checkbox" value="Incepta Website"
                                           {{ 'Incepta Website'== $emp_his_moreinfoid[0]->app_source ? 'checked=true"' : 'false'}} name="app_source_op"
                                           class="app_sour_opclss" value="Incepta Website"/>Incepta Website
                                </label>
                                <br>

                                <label style="word-wrap:break-word">
                                    <input type="checkbox"
                                           {{ 'Advertisement'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}} value="Advertisement"
                                           name="app_source_op" class="app_sour_opclss" value="Advertisement">
                                    Advertisement
                                </label>
                                <br>
                                <label style="word-wrap:break-word">
                                    <input type="checkbox"
                                           {{ 'Reference'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}} name="app_source_op"
                                           class="app_sour_opclss" value="Reference">
                                    Reference
                                </label>
                                <br>
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                           id="other_app_src_id"
                                           {{ 'Others'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}}  value="Others">
                                    Others (Please specify below)
                                    @if('Others'== $emp_his_moreinfoid[0]->app_source)
                                        <span id="app_s_op_id"
                                              style="font-weight: normal"><u>{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->app_sour_other:""}}</u></span>
                                    @endif

                                </label>
                            @else

                                <label style="word-wrap:break-word">
                                    <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                           value="Incepta Website"/>Incepta Website
                                </label>
                                <br>

                                <label style="word-wrap:break-word">
                                    <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                           value="Advertisement">
                                    Advertisement
                                </label>
                                <br>
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                           value="Reference">
                                    Reference
                                </label>
                                <br>
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                           id="other_app_src_id">
                                    Others (Please specify below)
                                </label>

                            @endif

                        </th>


                    </tr>
                </table>
            </th>

            <th style="border:1px solid black;" width="132.28346457px;height: 170.07874016px;">
                <?php
                $path = url('public/site_resource/images/passport_sized.jpg');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>

                @if(empty($emp_his_moreinfoid[0]->emp_img))
                    {{--<img id="img_prv" style="max-width: 150px; max-height: 150px; line-height: 20px;" src="{{url('public/site_resource/images/user.png')}}">--}}
                    <img id="img_prv" style="width: 132.28346457px; height: 170.07874016px;" src="{{$base64}}">

                @else

                    <?php
                    $path2 = url('public/emp_history_img/' . $emp_his_moreinfoid[0]->emp_img);
                    $type2 = pathinfo($path2, PATHINFO_EXTENSION);
                    $data2 = file_get_contents($path2);
                    $base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
                    ?>

                    <img id="img_prv" style="width: 132.28346457px; height: 170.07874016px;" src="{{$base642}}">

                @endif


            </th>

        </tr>

        </thead>


    </table>


</div>


<div class="row">
    <br>
    <div class="col-md-12 col-xs-12">

        <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
            <tr>
                <th style="text-align: left">1. Full Name</th>
                <th class="textdot" colspan="2" style="text-align: left"><span style="font-weight: normal"
                                                                               class="">{{$login_moreinfo[0]->sur_name_1st_upper}}</span>
                </th>
                <th style="text-align: left">2. Employee Code</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{$login_moreinfo[0]->emp_id}}</span></th>


            </tr>

            <tr>
                <th style="text-align: left">3. Designation (Present)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal">{{$login_moreinfo[0]->design_nam_1st_upper}}</span></th>
                <th style="text-align: left">4. Department</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{$login_moreinfo[0]->emp_dept_name_1st_upper}}</span></th>

            </tr>

            <tr>
                <th style="text-align: left">5. Designation ( at the time of joining)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid[0]->desig_first_time)>0 ?$emp_his_moreinfoid[0]->desig_first_time:""}}</span>
                </th>
                {{--<th colspan="2">(Designation at the time of joining): <span style="font-weight: normal">Assistant Officer</span></th>--}}
            </tr>


        </table>

    </div>
</div>

<div class="row">

    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 6. Present Address</p></strong>
        </label>

        <div class="col-md-12 col-xs-12">

            <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
                <tr style="width: 600px">

                    <th style="text-align: left"> C\O</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_careof:""}}</span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">1st address line</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_addr_1st:""}} </span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">2nd address line</th>
                    <th colspan="3" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_addr_2nd:""}} </span>
                    </th>
                    <th style="text-align: left">Police Station</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_police_sta:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Post office</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_post_off:""}} </span>
                    </th>
                    <th style="text-align: left">District</th>
                    <th class="textdot" style="text-align: left">
                        <span style="font-weight: normal">
                            @forelse($bd_dis as $bd_dis_s)

                                @if(!empty($emp_his_addr[0]->pre_dis))
                                    @if($emp_his_addr[0]->pre_dis==$bd_dis_s->dis_id)
                                        {{$bd_dis_s->dis_name}}
                                    @endif


                                @else



                                @endif

                            @empty

                            @endforelse
                        </span>
                    </th>
                    <th style="text-align: left">Post code</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_post_code:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Division</th>
                    <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                           @forelse($bd_div as $bd_divisions)

                                @if(!empty($emp_his_addr[0]->pre_div))
                                    @if($emp_his_addr[0]->pre_div==$bd_divisions->div_id)
                                        {{$bd_divisions->div_name}}
                                    @endif


                                @else



                                @endif

                            @empty

                            @endforelse


                        </span></th>
                    <th style="text-align: left">Country</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_country:"Bangladesh"}} </span>
                    </th>
                    <th style="text-align: left">Phone Number</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_phne:""}} </span>
                    </th>


                </tr>

            </table>

        </div>


    </div>
</div>
<div class="row">

    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 7. Permanent Address</p></strong>
        </label>

        <div class="col-md-12 col-xs-12">

            <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
                <tr style="width: 600px">

                    <th style="text-align: left"> C/O</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_careof:""}} </span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">1st address line</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_addr_1st:""}} </span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">2nd address line</th>
                    <th colspan="3" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_addr_2nd:""}} </span>
                    </th>
                    <th style="text-align: left">Police Station</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_police_sta:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Post office</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_post_off:""}} </span>
                    </th>
                    <th style="text-align: left">District</th>
                    <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                              @forelse($bd_dis as $bd_dis_s)

                                @if(!empty($emp_his_addr[0]->per_dis))
                                    @if($emp_his_addr[0]->per_dis==$bd_dis_s->dis_id)
                                        {{$bd_dis_s->dis_name}}
                                    @endif


                                @else



                                @endif

                            @empty

                            @endforelse

                        </span></th>
                    <th style="text-align: left">Post code</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_post_code:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Division</th>
                    <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                        @forelse($bd_div as $bd_divisions)

                                @if(!empty($emp_his_addr[0]->per_div))
                                    @if($emp_his_addr[0]->per_div==$bd_divisions->div_id)
                                        {{$bd_divisions->div_name}}
                                    @endif

                                @else

                                @endif
                            @empty

                            @endforelse
                    </span></th>
                    <th style="text-align: left">Country</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_country:"Bangladesh"}} </span>
                    </th>
                    <th style="text-align: left">Phone Number</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_phne:""}} </span>
                    </th>


                </tr>

            </table>

        </div>


    </div>
</div>
<div class="row">

    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 8. Emergency Address (Name & full address of person
                    to be notified in case of
                    emergency)</p></strong>
        </label>

        <div class="col-md-12 col-xs-12">

            <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
                <tr style="width: 600px">

                    <th style="text-align: left"> C\O</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_careof:""}}</span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">1st address line</th>
                    <th colspan="5" class="textdot" style="text-align: left"><span
                                style="font-weight: normal">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_addr_1st:""}}</span>
                    </th>

                </tr>
                <tr>

                    <th style="text-align: left">2nd address line</th>
                    <th colspan="3" class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_addr_2nd:""}}</span>
                    </th>
                    <th style="text-align: left">Police Station</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_police_sta:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Post office</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_post_off:""}} </span>
                    </th>
                    <th style="text-align: left">District</th>
                    <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                              @forelse($bd_dis as $bd_dis_s)

                                @if(!empty($emp_his_addr[0]->emer_dis))
                                    @if($emp_his_addr[0]->emer_dis==$bd_dis_s->dis_id)
                                        {{$bd_dis_s->dis_name}}
                                    @endif


                                @else



                                @endif

                            @empty

                            @endforelse


                        </span></th>
                    <th style="text-align: left">Post code</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_post_code:""}} </span>
                    </th>


                </tr>
                <tr>
                    <th style="text-align: left">Division</th>
                    <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                             @forelse($bd_div as $bd_divisions)

                                @if(!empty($emp_his_addr[0]->emer_div))
                                    @if($emp_his_addr[0]->emer_div==$bd_divisions->div_id)
                                        {{$bd_divisions->div_name}}
                                    @endif

                                @else
                                    <option data-divnam="{{$bd_divisions->div_name}}"
                                            value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>

                                @endif


                            @empty
                                <option>No Data Found</option>
                            @endforelse

                        </span></th>
                    <th style="text-align: left">Country</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_country:"Bangladesh"}} </span>
                    </th>
                    <th style="text-align: left">Phone Number</th>
                    <th class="textdot" style="text-align: left"><span
                                style="font-weight: normal"> {{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_phne:""}} </span>
                    </th>


                </tr>

            </table>

        </div>


    </div>
</div>

<div class="row">

    <div class="col-md-12 col-xs-12">
        <br>
        <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
            <tr>
                <th style="text-align: left">9. Date of birth(S.S.C)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid[0]->birt_dt_ssc)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->birt_dt_ssc)->format('d/m/Y'):""}}</span>
                </th>
                <th style="text-align: left">9(a). Date of birth(Original)</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal">{{ count($emp_his_moreinfoid[0]->birth_dt_ori)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->birth_dt_ori)->format('d/m/Y'):""}}</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">10. Place of birth (District)</th>
                <th class="textdot" colspan="2" style="text-align: left">
                    <span style="font-weight: normal">
                         @forelse($bd_dis as $bd_districts)
                            @if (!count($emp_his_infoid)>0)


                            @else

                                @if($bd_districts->dis_id == $emp_his_infoid[0]->birth_place)
                                    {{$bd_districts->dis_name}}
                                @endif

                            @endif


                        @empty

                        @endforelse

                    </span></th>
                <th style="text-align: left">11. Country of birth</th>
                <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                        @forelse($all_country as $all_country)
                            @if (count($emp_his_moreinfoid)>0)
                                @if($all_country->country_id == $emp_his_moreinfoid[0]->birth_place_cuntry)
                                    {{$all_country->country_name}}
                                @endif
                            @else

                            @endif
                        @empty

                        @endforelse
                    </span></th>


            </tr>
            <tr>
                <th style="text-align: left">12. NID Number</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid[0]->nid)>0 ?$emp_his_moreinfoid[0]->nid:""}}</span>
                </th>
                <th style="text-align: left">13. Nationality</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal">{{count($emp_his_infoid[0]->nationality)>0 ? $emp_his_infoid[0]->nationality:''}}</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">14. Marital Status</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal">{{count($emp_his_infoid[0]->maritial_status)>0?$emp_his_infoid[0]->maritial_status:""}}</span>
                </th>
                <th style="text-align: left">15. Marriage date</th>
                <th class="textdot" style="text-align: left">
                    <span style="font-weight: normal">
                        @if($emp_his_infoid[0]->maritial_status=='Married')
                            {{ count($emp_his_moreinfoid[0]->marriage_date)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->marriage_date)->format('d/m/Y'):""}}
                        @endif
                    </span>
                </th>


            </tr>

            <tr>
                <th style="text-align: left">16. No of Children</th>
                <th class="textdot" colspan="2" style="text-align: left">
                    <span style="font-weight: normal">
                        @if($emp_his_infoid[0]->maritial_status=='Married'||$emp_his_infoid[0]->maritial_status=='Divorced'||$emp_his_infoid[0]->maritial_status=='Widowed'||$emp_his_infoid[0]->maritial_status=='Separated')
                            {{ count($emp_his_moreinfoid[0]->no_of_child)>0 ?$emp_his_moreinfoid[0]->no_of_child:""}}
                        @endif
                    </span></th>
                <th style="text-align: left">17. Religion</th>
                <th class="textdot" style="text-align: left">
                    <span style="font-weight: normal">
                        {{count($emp_his_infoid[0]->religion)>0?$emp_his_infoid[0]->religion:""}}
                    </span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">18. Mobile (Official)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid[0]->emp_mob_no_offi)>0 ?$emp_his_moreinfoid[0]->emp_mob_no_offi:""}}</span>
                </th>
                <th style="text-align: left">19. Mobile (Personal)</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid[0]->emp_mob_no_per)>0 ?$emp_his_moreinfoid[0]->emp_mob_no_per:""}}</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">20. Email(Personal)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal;@php if(strlen($emp_his_moreinfoid[0]->emp_mail_per) > 26) echo 'font-size: 11px;' @endphp">{{ count($emp_his_moreinfoid[0]->emp_mail_per)>0 ?$emp_his_moreinfoid[0]->emp_mail_per:""}}</span>
                </th>
                <th style="text-align: left">21. Email (Official)</th>
                <th class="textdot" style="text-align: left">
                    <span style="font-weight: normal;@php if(strlen($emp_his_moreinfoid[0]->emp_mail_offi) > 26) echo 'font-size: 10px;' @endphp">
                        {{ count($emp_his_moreinfoid[0]->emp_mail_offi)>0 ?$emp_his_moreinfoid[0]->emp_mail_offi:""}}
                    </span>
                </th>
            </tr>

        </table>

    </div>
</div>
{{--<div class="page_break"></div>--}}
<div class="row">
    {{--    <br>--}}
    {{--    <br>--}}
    {{--    <br>--}}
    {{--    <br>--}}
    <div class="col-md-12 col-xs-12">

        <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
            <tr>
                <th style="text-align: left">22. Passport Number (if any)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->emp_passport_no:""}}</span>
                </th>
                <th style="text-align: left">23. Driving License (if any)</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->drive_license:""}}</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">24. TIN Number (if any)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal">{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->tin_no:""}}</span>
                </th>
                <th style="text-align: left">25. Gender*</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_infoid)>0 ?$emp_his_infoid[0]->gender :" " }}</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">26. Bank A/C number (Personal)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->bank_ac_no:""}}</span>
                </th>
                <th style="text-align: left">27. Height(in ft & inch)</th>
                <th class="textdot" style="text-align: left"><span style="font-weight: normal"> {{ count($emp_his_moreinfoid)>0 ? explode(' ',$emp_his_moreinfoid[0]->emp_height)[0]:""}} ft {{ count($emp_his_moreinfoid[0]->emp_height)>0 ?explode(' ',$emp_his_moreinfoid[0]->emp_height)[2]:""}}  inch</span>
                </th>


            </tr>
            <tr>
                <th style="text-align: left">28. Bank Name (Personal)</th>
                <th class="textdot" colspan="2" style="text-align: left"><span
                            style="font-weight: normal">{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->bank_name:""}}</span>
                </th>
                <th style="text-align: left">29. Blood Group</th>
                <th class="textdot" style="text-align: left"><span
                            style="font-weight: normal"> {{ count($emp_his_infoid)>0 ? $emp_his_infoid[0]->blood_group : " "}}</span>
                </th>


            </tr>

        </table>

    </div>
</div>

<div class="row">
    <br>
    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 30. Eductaion:(Start from recent)</p></strong>
        </label>


        <table class="table table-bordered education_table" width="100%">

            <!-- thead -->
            <thead>
            <tr>
                <th>Name of <br>Degree</th>
                <th>Name of <br>Institute</th>
                <th>Group</th>
                <th>Subject/ <br>Specialization</th>
                <th>Board</th>
                <th>Passing <br>Year</th>
                <th>Division/ <br>CGPA</th>
                <th>Marks%</th>
            </tr>

            </thead>
            <!-- TBODY -->
            <tbody>
            @forelse($emp_his_edu_old as $emp_his_edu_old)

                <tr>

                    <td>
                        {{--                        {{ $emp_his_edu_old->edu_desig_name}}--}}
                        @forelse($edu_all_degree as $edu_all_d)
                            @if($emp_his_edu_old->edu_desig_name== $edu_all_d->deg_id)
                                {{$edu_all_d->degree_name}}
                            @else

                            @endif
                        @empty


                        @endforelse
                    </td>
                    <td>
                        {{$emp_his_edu_old->edu_insti_name}}
                    </td>
                    <td>

                        @forelse($edu_all_grp as $edu_all_g)


                            @if (count($emp_his_edu_old)>0)
                                @if(($emp_his_edu_old->edu_desig_name==5||$emp_his_edu_old->edu_desig_name==11||$emp_his_edu_old->edu_desig_name==12))

                                    @if($edu_all_g->deg_grp_pkid==1)

                                        @if($emp_his_edu_old->edu_group == $edu_all_g->grp_id)
                                            {{$edu_all_g->grp_name}}
                                        @else

                                        @endif
                                    @endif
                                @else

                                    @if($edu_all_g->deg_grp_pkid==2)
                                        @if($emp_his_edu_old->edu_group == $edu_all_g->grp_id)
                                            {{$edu_all_g->grp_name}}
                                        @else

                                        @endif

                                    @endif
                                @endif
                            @else

                            @endif

                        @empty
                            <option>No Data Found</option>
                        @endforelse


                    </td>
                    <td>
                        {{$emp_his_edu_old->edu_subject}}
                    </td>
                    <td>
                        {{--{{$emp_his_edu_old->edu_board}}--}}

                        @forelse($edu_all_board as $edu_all_b)

                            @if (count($emp_his_edu_old)>0)
                                @if($emp_his_edu_old->edu_board == $edu_all_b->board_id)
                                    {{$edu_all_b->board_name}}
                                @else
                                @endif
                            @else

                            @endif

                        @empty
                            <option>No Data Found</option>
                        @endforelse

                    </td>
                    <td>
                        {{$emp_his_edu_old->edu_passing_yr}}
                    </td>
                    <td>
                        {{$emp_his_edu_old->edu_div_cgpa === 'cgpa' ? strtoupper($emp_his_edu_old->edu_div_cgpa) : ucfirst($emp_his_edu_old->edu_div_cgpa)}}
                    </td>
                    <td>
                        {{strpos($emp_his_edu_old->edu_marks,'_') !== false ? str_replace("_"," ",$emp_his_edu_old->edu_marks):$emp_his_edu_old->edu_marks}}
                    </td>

                </tr>
            @empty

            @endforelse

            </tbody>

        </table>
    </div>
</div>
<div class="row">
    <label for="">
        <strong>
            <p style="font-size: 16px"> 31. Language Proficiency</p>
        </strong>
    </label>
    <div class="col-xs-12">
        <table class="table table-bordered lang_table">
            <thead>
            <tr>
                <th>Language</th>
                <th>Level</th>
            </tr>
            </thead>
            <tbody>
               @foreach($emp_his_language as $lang)
                   <tr>
                       <td>{{$lang->lang}}</td>
                       <td>{{$lang->lang_level}}</td>
                   </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <label for="">
        <strong>
            <p style="font-size: 16px"> 32. Employment History</p>
        </strong>
    </label>
    <div class="col-xs-12">
        <div class="row"><label for="">
                <strong><p style="font-size: 14px "> 32.(a) External History</p></strong>
            </label>
            <table class="table table-bordered education_table" style="width: 100%">
                <!-- thead -->
                <thead>
                <tr>
                    <th>Name of the Company</th>
                    <th>Designation</th>
                    <th>From</th>
                    <th>to</th>
                    <th>Reference Name</th>
                    <th>Contact Number</th>
                    <th>Reason For leaving</th>
                </tr>


                </thead>
                <!-- TBODY -->
                <tbody>
                @forelse($emp_his_emplment_old_ext as $emp_his_emplment_old)
                    <tr>

                        <td>
                            {{$emp_his_emplment_old->emplo_comp_name}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->emplo_desig}}
                        </td>
                        <td>
                            {{--                        {{$emp_his_emplment_old->emplo_from}}--}}
                            {{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_from)->format('d/m/Y')}}

                        </td>
                        <td>
                            {{--                        {{$emp_his_emplment_old->emplo_to}}--}}
                            {{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_to)->format('d/m/Y')}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->emplo_ref_name}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->emplo_cont_no}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->emplo_rea_lev}}
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No Data Available</td>

                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row"><label for="">
                <strong><p style="font-size: 14px "> 32.(b) Internal History</p></strong>
            </label>
            <table class="table table-bordered education_table" style="width: 100%">
                <!-- thead -->
                <thead>
                <tr>
                    <th>Name of the Company</th>
                    <th>Designation</th>
                    <th>From</th>
                    <th>to</th>
                    <th>Department</th>
                </tr>
                </thead>
                <!-- TBODY -->
                <tbody>
                @forelse($emp_his_emplment_old_int as $emp_his_emplment_old)
                    <tr>
                        <td>
                            {{$emp_his_emplment_old->emplo_comp_name}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->emplo_desig}}
                        </td>
                        <td>
                            {{--                        {{$emp_his_emplment_old->emplo_from}}--}}
                            {{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_from)->format('d/m/Y')}}

                        </td>
                        <td>
                            {{--                        {{$emp_his_emplment_old->emplo_to}}--}}
                            {{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_to)->format('d/m/Y')}}
                        </td>
                        <td>
                            {{$emp_his_emplment_old->department}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No Data Available</td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>
    </div>
</div>
<div class="row">
    <br>
    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 33. Family details (Father/Mother/Spouse/Children/Brother/Sister)</p>
            </strong>
        </label>
        <table>
            <thead>
            <tr>
                <th style="font-size: 14px;">33(a). Father's Name</th>
                <th style="font-size: 14px;font-weight:normal"
                    class="textdot"> {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->father_name:""}} </th>
            </tr>

            </thead>
        </table>
        <br>
        <table class="table table-bordered education_table" style="width: 100%">

            <!-- thead -->
            <thead>
            <tr>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Country of birth</th>
                <th>Nationality</th>
                <th>Mobile No</th>
            </tr>

            </thead>
            <!-- TBODY -->
            <tbody>
            <tr>

                <td>
                    {{ count($emp_hisfamidetail[0]->fa_bir_date)>0 ?\Carbon\Carbon::parse($emp_hisfamidetail[0]->fa_bir_date)->format('d/m/Y'):""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_place_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_cuntry_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_nationality:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_mob_no:""}}
                </td>

            </tr>

            </tbody>

        </table>
        <br>
        <table>
            <thead>
            <tr>
                <th style="font-size: 14px;">33(b). Mother's Name</th>
                <th style="font-size: 14px;font-weight:normal"
                    class="textdot"> {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mother_name:""}}</th>
            </tr>

            </thead>
        </table>
        <br>
        <table class="table table-bordered education_table" style="width: 100%">

            <!-- thead -->
            <thead>
            <tr>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Country of birth</th>
                <th>Nationality</th>
                <th>Mobile No</th>
            </tr>

            </thead>
            <!-- TBODY -->
            <tbody>
            <tr>

                <td>
                    {{ count($emp_hisfamidetail[0]->mo_bir_date)>0 ?\Carbon\Carbon::parse($emp_hisfamidetail[0]->mo_bir_date)->format('d/m/Y'):""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_place_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_cuntry_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_nationality:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_mob_no:""}}
                </td>

            </tr>

            </tbody>

        </table>
        <br>
        <table>
            <thead>
            <tr>
                <th style="font-size: 14px;">33(c). Spouse Name</th>
                <th style="font-size: 14px;font-weight:normal"
                    class="textdot">{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->spouse_name:""}} </th>
            </tr>

            </thead>
        </table>
        <br>
        <table class="table table-bordered education_table" style="width: 100%">

            <!-- thead -->
            <thead>
            <tr>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Country of birth</th>
                <th>Nationality</th>
                <th>Mobile No</th>
            </tr>

            </thead>
            <!-- TBODY -->
            <tbody>
            <tr>

                <td>
                    {{ count($emp_hisfamidetail[0]->sp_bir_date)>0 ? \Carbon\Carbon::parse($emp_hisfamidetail[0]->sp_bir_date)->format('d/m/Y'):""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail[0]->sp_place_birth)>0 ?$emp_hisfamidetail[0]->sp_place_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_cuntry_birth:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_nationality:""}}
                </td>
                <td>
                    {{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_mob_no:""}}
                </td>

            </tr>

            </tbody>

        </table>
        <br>
        <table>
            <thead>
            <tr>
                <th style="font-size: 14px;">33(d). Children(s)/Brother(s)/Sister(s) details</th>
                {{--<th style="font-size: 14px;" class="textdot"> vcv fder </th>--}}
            </tr>

            </thead>
        </table>
        <br>
        <table class="table table-bordered education_table" style="width: 100%">

            <!-- thead -->
            <thead>
            <tr>

                <th>Name</th>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Country of birth</th>
                <th>Nationality</th>
                <th>Relation</th>

            </tr>

            </thead>
            <!-- TBODY -->
            <tbody>
            @forelse($emp_his_cbs_old as $emp_his_cbs_old)
                <tr>

                    <td>{{$emp_his_cbs_old->cbs_title}} {{$emp_his_cbs_old->cbs_name}}   </td>
                    <td>
                        {{--                        {{$emp_his_cbs_old->cbs_date_birth}}--}}
                        {{ isset($emp_his_cbs_old->cbs_date_birth) ? \Carbon\Carbon::parse($emp_his_cbs_old->cbs_date_birth)->format('d/m/Y') : ''}}
                    </td>
                    <td>{{$emp_his_cbs_old->cbs_plac_birth}} </td>
                    <td>{{$emp_his_cbs_old->cbs_cuntry_birth}}       </td>
                    <td> {{$emp_his_cbs_old->cbs_nationality}}    </td>
                    <td>{{$emp_his_cbs_old->cbs_relation }}         </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">No Data</td>

                </tr>

            @endforelse

            </tbody>

        </table>
    </div>
</div>
<div class="row">
    <br>
    <div>
        <label for="">
            <span style="font-size: 14px"><b>34. Have you any relative
                    in Incepta? </b></span>
        </label>

    </div>

    <label style="word-wrap:break-word">
        <input type="checkbox"
               {{ 'No'== $emp_his_moreinfoid[0]->relative_incep ?  'checked=true"' : 'false'}} name="app_source_op"
               class="app_sour_opclss" value="No"/>No
    </label>
    <label style="word-wrap:break-word">
        <input type="checkbox"
               {{ 'Yes'== $emp_his_moreinfoid[0]->relative_incep  ?  'checked=true"' : 'false'}} name="app_source_op"
               class="app_sour_opclss" value="Yes"/>Yes
    </label>

    @if('Yes' == $emp_his_moreinfoid[0]->relative_incep)
        <span id="emp_inceprel_divid">

        <span style="font-weight: bold;font-size: 15px">Employee Name</span> <span
                    class=""><u>{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_empnam:""}}</u></span>
        <span style="font-weight: bold;font-size: 15px">Employee Code</span> <span
                    class=""><u>{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_empcode:""}}</u></span>
        <span style="font-weight: bold;font-size: 15px">Employee Relation</span> <span
                    class=""><u> {{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_emprel:""}}</u></span>
    </span>

    @endif

    <span id="emp_inceprel_divid">
    </span>

</div>
<div class="row">
    <br>
    <div class="col-xs-12">
        <label for="">
            <strong><p style="font-size: 16px "> 35. Professional Qualification / Specialized Training (Start from recent)</p></strong>
        </label>

        <table class="table table-bordered education_table" style="width: 100%">

            <!-- thead -->
            <thead>
            <tr>
                <th>Institution Name</th>
                <th>From</th>
                <th>To</th>
                <th>Duration</th>
                <th>Course Name</th>
                <th>Result</th>
                <th>Country</th>
            </tr>


            </thead>
            <!-- TBODY -->
            <tbody>
            @forelse($emp_his_pro_quali as $emp_his_pro_quali)
                <tr>

                    <td>
                        {{$emp_his_pro_quali->pro_insti_nam}}
                    </td>
                    <td>

                        {{ \Carbon\Carbon::parse($emp_his_pro_quali->pro_from)->format('d/m/Y')}}
                    </td>
                    <td>

                        {{ \Carbon\Carbon::parse($emp_his_pro_quali->pro_to)->format('d/m/Y')}}
                    </td>
                    <td>
                        {{$emp_his_pro_quali->pro_duration}}
                    </td>
                    <td>
                        {{$emp_his_pro_quali->pro_cour_nam}}
                    </td>
                    <td>
                        {{$emp_his_pro_quali->pro_result}}
                    </td>
                    <td>
                        {{$emp_his_pro_quali->pro_cuntry}}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No Data Available</td>

                </tr>
            @endforelse

            </tbody>

        </table>
    </div>
</div>

<div class="page_break"></div>

<div class="row" style="margin-top:35px">

    <div class="row" style="float: right">
        Employee Code: {{$login_moreinfo[0]->emp_id}}
    </div>    

    <table class="tableintro tableborder" width="100%" style="border:1px dashed black;">
        
        <thead>


        <tr style="border:1px solid black;margin-top: 10px">


            <th style="text-align: left;padding-left: 3px;left: 0px;top: 0px;">
                <span style="font-size: 14px;font-weight:normal"> <b>36. </b></span><span
                        style="font-size: 13px;"><b><u> Nominee Declaration</u></b></span> <br>
                <span style="font-weight:normal"> I do hereby nominate the following individual/s as my nominee who will in the event of my death or any other unavoidable absence receive the amount, according to the following % of share, at the time of final settlement in Incepta Pharmaceuticals Ltd.
                </span>
            </th>

            <th style="border:1px solid black;" width="132.28346457px;height: 170.07874016px;">
                <?php
                $path = null;
                $message = '';
                if (isset($emp_his_nomi_data[0]) && $emp_his_nomi_data[0]->nominee_img) {
                    $path = url('public/emp_history_img/nominee/') . '/' . $emp_his_nomi_data[0]->nominee_img;
                } else {
                    $message = 'Please attach one copy passport size photograph/s of nominee/s duly signed by the nominee and attested by you on the back side';
                    $path = public_path('site_resource/images/passport_sized.jpg');
                }

                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                ?>

                <div style="position: relative;">
                    <img id="img_prv" style="width: 132.28346457px; height: 170.07874016px;" src="{{$base64}}">
                    <div style="position: absolute;top:40px;left: 10px;font-weight: normal;font-size: 11px;">
                        {{$message}}</div>
                </div>
            </th>

        </tr>

        </thead>


    </table>


</div>
<div class="row">
    
    <br>
    <div class="col-xs-12">
        <table class="table table-bordered education_table" style="width: 100%">
            <!-- thead -->
            <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Contact No.</th>
                <th>Relationship</th>
                <th>% of Share</th>
            </tr>
            </thead>
            <!-- TBODY -->
            <tbody>
            @forelse($emp_his_nomi_data as $nominee)
                <tr>
                    <td>
                        {{$nominee->nominee_nam}}
                    </td>
                    <td>
                        {{$nominee->nominee_addr}}
                    </td>
                    <td>
                        {{$nominee->nominee_mob_no}}
                    </td>
                    <td>
                        {{$nominee->nominee_rel}}
                    </td>
                    <td>
                        {{$nominee->nominee_share}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No Data</td>

                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($login_moreinfo[0]->emp_dept_name=='DISTRIBUTION' || $login_moreinfo[0]->emp_dept_name=='CENTRAL WAREHOUSE')
    <div class="row">
        <br>
        <div class="col-xs-12">
            <label for="">
                <strong><p style="font-size: 16px "> 37. Guarantor Details </p></strong>
            </label>

            <div class="col-md-12 col-xs-12">

                <table class="tablebasic" width="100%" style="font-size: 15px;text-align: left">
                    <tr>
                        <th style="text-align: left">Guarantor Name</th>
                        <th colspan="3" class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_nam:""}}</span>
                        </th>
                        <th style="text-align: left">Relation</th>
                        <th class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_relation:""}} </span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Home Address</th>
                        <th colspan="5" class="textdot" style="text-align: left">
                            <span style="font-weight: normal">{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_homeaddr:""}}</span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Police Station</th>
                        <th class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_polista:""}} </span>
                        </th>
                        <th style="text-align: left">Post office</th>
                        <th class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_postoff:""}} </span>
                        </th>
                        <th style="text-align: left">Post code</th>
                        <th class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_pcode:""}} </span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">District</th>
                        <th class="textdot" style="text-align: left">
                            <span style="font-weight: normal">
                           @forelse($bd_dis as $bd_dis_s)

                                    @if(!empty($emp_his_qurantr_data[0]->guarantor_dist))
                                        @if($emp_his_qurantr_data[0]->guarantor_dist==$bd_dis_s->dis_id)
                                            {{$bd_dis_s->dis_name}}
                                        @endif

                                    @else

                                    @endif

                                @empty

                                @endforelse
                            </span>
                        </th>
                        <th style="text-align: left">Division</th>
                        <th class="textdot" style="text-align: left"><span style="font-weight: normal">
                            @forelse($bd_div as $bd_divisions)

                                    @if(!empty($emp_his_qurantr_data[0]->guarantor_div))
                                        @if($emp_his_qurantr_data[0]->guarantor_div==$bd_divisions->div_id)
                                            {{$bd_divisions->div_name}}
                                        @endif

                                    @else

                                    @endif

                                @empty

                                @endforelse
                    </span></th>
                        <th style="text-align: left">Country</th>
                        <th class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_cuntry:"Bangladesh"}} </span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Organization name</th>
                        <th class="textdot" colspan="2" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_orgname:""}} </span>
                        </th>
                        <th style="text-align: left">Designation</th>
                        <th class="textdot" colspan="2" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_desig:""}} </span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Address</th>
                        <th colspan="8" class="textdot" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_orgaddr:""}} </span>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Email</th>
                        <th class="textdot" colspan="2" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_email:""}} </span>
                        </th>
                        <th style="text-align: left">Contact Number</th>
                        <th class="textdot" colspan="2" style="text-align: left"><span
                                    style="font-weight: normal"> {{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_cno:""}} </span>
                        </th>
                    </tr>
                </table>

            </div>


        </div>
    </div>
@endif


<div class="row">
    <label for="">
        <p style="font-size: 14px;">
            <strong>
                {{ $login_moreinfo[0]->emp_dept_name=='DISTRIBUTION'  || $login_moreinfo[0]->emp_dept_name=='CENTRAL WAREHOUSE' ?'38':'37'}}
                . References with full address and
                phone number

            </strong>
        </p>
    </label>

</div>


<div class="rowref" style="display: flex;">
    <div class="colref" style="float:left;width:45%; padding: 2px; border: 1px solid black;page-break-inside: avoid;">
        <table>
            <thead>
            <tr>
                <th style="font-size:14px;text-align: left">Name</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_nam:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Phone No.</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_mob_no:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Organization/Address</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_addr:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Designation</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_desig:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Email</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_email:""}}</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="colref" style="font-size:14px;width:45%;float:right; padding: 2px; border: 1px solid black;page-break-inside: avoid;">
        <table>
            <thead>
            <tr>
                <th style="font-size:14px;text-align: left">Name</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_nam:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Phone No.</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_mob_no:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Organization/Address</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_addr:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Designation</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_desig:""}}</th>
            </tr>
            <tr>
                <th style="font-size:14px;text-align: left">Email</th>
                <th style="font-size:14px;text-align: left;font-weight: normal">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_email:""}}</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<br>


<div class="row">
    <br>
    <br>
    <span style="font-size: 14px;">
        I certify that the statements made by me in answer to the foregoing information are true, complete and correct to the best of my knowledge and belief. Permission is given to Incepta Pharmaceuticals Ltd to make such investigations as are necessary on the information given above. I understand that any misrepresentation or material omission made herein or in any other documents requested by Incepta Pharmaceuticals Ltd render a staff member liable to termination of service or dismissal.

    </span>
</div>

<div class="row">
    <br>
    <br>
    <br>
    <br>
    <table class="table table-bordered d_sig_table" style="width: 100%">

        <!-- thead -->
        <thead>
        <tr>
            <th style="text-align: left">Date ___________________________</th>
            <th style="text-align: left">Signature _________________________________</th>

        </tr>

        </thead>
        <!-- TBODY -->

    </table>
</div>

{{--main body end--}}


</body>
{{--{{Html::script('public/site_resource/js/bootstrap-fileupload.min.js')}}--}}
</html>
