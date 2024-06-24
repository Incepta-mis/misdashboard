@extends('_layout_shared._master')
@section('title','Profile')
@section('styles')
    <style>
        .container-profile {
            /*width: 400px;*/
            margin: 80px auto 120px;
            background-color: #fff;
            padding: 0 20px 20px;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.075);
            -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.075);
            text-align: center;
        }

        .avatar-flip {
            border-radius: 100px;
            overflow: hidden;
            height: 150px;
            width: 150px;
            position: relative;
            margin: auto;
            top: -60px;
            transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            box-shadow: 0 0 0 13px #f0f0f0;
            -webkit-box-shadow: 0 0 0 13px #f0f0f0;
            -moz-box-shadow: 0 0 0 13px #f0f0f0;
        }

        .avatar-flip img {
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 100px;
            transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
        }

        .avatar-flip img:first-child {
            z-index: 1;
        }

        h2 {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            padding-top: 0;
            margin-top: 0;
        }

        h4 {
            font-size: 16px;
            color: #337ab7;
            letter-spacing: 1px;
            margin-bottom: 25px
        }

        .table td {
            text-align: left;
            font-weight: bold;
        }

        .pb {
            padding-bottom: 4px;
        }

        .left-border {
            border-left: 3px solid #337ab7;
        }

        .right-border {
            border-right: 3px solid #337ab7;
        }

        .text-blue {
            color: #337ab7;
        }

        #btnEdit, #btnView:hover {
            cursor: pointer;
        }

        .btn{
            padding: 0;
        }

        td{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <link rel="stylesheet" href="{{url('public/site_resource/css/salert/sweetalert2.min.css')}}">
@endsection
@section('right-content')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
            <div class="container-profile">
                <div class="avatar-flip">
                    <img src="{{url('public/site_resource/images/user.png')}}" height="150" width="150">
                </div>
                <h2>
                    @if(count($user_info ) > 0)
                        {{ucwords(strtolower($user_info[0]->name))}}
                    @else
                        {{Auth::user()->name}}
                    @endif
                </h2>
                <hr style="padding: 0;margin: 0">
                <h4>
                    @if(count($user_info) > 0 && $user_info[0]->desig !== 'NA')
                        <strong>{{ucwords(strtolower($user_info[0]->desig))}}</strong>
                    @else
                        <strong>{{Auth::user()->desig}}</strong>
                    @endif
                </h4>
                <table class="table table-condensed table-striped table-hover" width="100%" style="table-layout: fixed;">
                    <tr>
                        <td class="text-blue left-border" width="30%">Email</td>
                        <td title="{{Auth::user()->email}}">
                            {{Auth::user()->email}}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-border text-blue">Password</td>
                        <td>
                            <span id="pass_hidden" style="font-weight: bold">............</span>
                            <span id="pass_visible" style="font-weight: bold;display: none;">{{Auth::user()->raw_password}}</span>
                            <span class="pull-right">
                                <i class="fa fa-eye-slash btn btn-sm" style="font-size: 16px;" title="view password"
                                   id="btnView"></i>
                                |<i class="fa fa-pencil btn btn-sm" style="font-size: 16px;" title="change password"
                                   id="btnEdit"></i>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        {{-- <td class="left-border text-blue" >P.Group</td>
                        <td>{{Auth::user()->p_group}}</td> --}}
                        <td colspan="2" class="text-primary" style="text-align: center;">
                            <i>Incepta Pharmaceuticals Ltd.</i>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script src="{{url('public/site_resource/js/salert/sweetalert2.min.js')}}"></script>
            <script type="text/javascript">
                var raw = '';
                $(document).on('click', '#btnEdit', function () {

                    swal({
                        text: "Enter New Password",
                        input: "text",
                        inputPlaceholder: 'password',
                        showCancelButton: true,
                        confirmButtonText: "Change",
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        inputAutoTrim: true,
                        preConfirm: function (value) {
                            return new Promise(function (resolve) {
                                setTimeout(function () {
                                    if (value === '') {
                                        swal.showValidationError(
                                            'Field Can\'t be empty'
                                        )
                                    }
                                    resolve()
                                }, 2000)
                            })
                        }

                    }).then(function (result) {

                        //console.log(result);

                        swal.disableConfirmButton();
                        if (!result.dismiss) {
                            $('.swal2-cancel').prop('disabled', true);
                            $.ajax({
                                url: "{{url('user/changePass')}}",
                                type: 'POST',
                                data: {n_pass: result.value.trim(), '_token': '{{Session::token()}}'},
                                success: function (response) {

                                    if (response.status == "success") {
                                        swal({
                                            text: 'Password Changed Successfully',
                                            type: 'success',
                                            confirmButtonText: 'Ok'
                                        }).then(function (result) {
                                            window.location.reload();
                                        })
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
                                }
                            });
                        }

                    });

                });
                $('#btnView').on('click',function (){
                   if($('#pass_hidden').is(":visible")){
                       $('#pass_hidden').hide();
                       $('#pass_visible').show();
                       $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                   }else{
                       $('#pass_hidden').show();
                       $('#pass_visible').hide();
                       $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                   }
                });
            </script>
@endsection
