@extends('_layout_login._login_register_master')
@section('title','MIS Dashboard')
@section('styles')
    <style>
        .registration > a{
            cursor: pointer;
            text-decoration: none;
        }

        .login-body{
            display: flex;
            align-items: center;
            height: 100vh;
        }
    </style>
@endsection
@section('body-content')

    <form class="form-signin" id="loginform" action="{{url('login')}}" method="post">
        {{csrf_field()}}
        <div class="form-signin-heading text-center" style="padding: 5px 5px;">
            <h1 class="sign-title" style="text-transform: none;">Sign In</h1>
            {{Html::image('public/site_resource/images/incepta.png','',['width'=>'260px','height'=>'150px'])}}
        </div>

        <div class="login-wrap">

            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissable" style="font-family: 'Raleway', sans-serif;">
                    {{-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> --}}
                    <ul class="text-center list-unstyled" >
                        @foreach($errors->all() as $error)
                            <li><strong>{{$error}}!</strong></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable" style="font-family: 'Raleway', sans-serif;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="text-center"><strong>{{Session::get('message')}}</strong></span>
                </div>
            @endif

            <input type="text" class="form-control" name="user_id" placeholder="User ID" value="{{old('user_id')}}" autofocus>

            <input type="password" class="form-control" name="upassword" placeholder="Password">

            <button class="btn btn-lg btn-login btn-block" name="submit" type="submit">
                <i class="fa fa-check"></i>
            </button>

            <div class="registration">
                <!--  Not a member yet? -->
               <!--  <a class="" href="{{url('register')}}">
                    Signup |
                </a> -->
                <a id="modalForgot"> Forgot Password?</a>

            </div>
            <!--   <label class="checkbox">
                  <input type="checkbox" value="remember-me"> Remember me
                  <span class="pull-right">
                      <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                  </span>
              </label> -->

        </div>

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <form id="data">
                        <div class="modal-body">
                            <p style="color: #000000;">Enter your employee id below.</p>
                            <input type="text"  id="emp_code" placeholder="Employee id" autocomplete="off"
                                   class="form-control placeholder-no-fix">
                            <p><span id="response" style="color: #000000;"></span></p>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button data-dismiss="modal" id="btnCancel" onclick="dismiss()" class="btn btn-default"
                                type="button">Close
                        </button>
                        <button class="btn btn-primary" id="btnSubmit" onclick="retrieve_pass()" type="button">Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <footer class="sticky-footer"
            style="text-align:center; background: none;color: white;font-weight: bold;position:fixed;" id="footer_log">
        <label>Developed by Incepta | Department of Information Technology | Head Office</label>
    </footer>

@endsection

@section('scripts')
{{Html::script('public/site_resource/js/recvr_pass.js')}}
 <script>
     url = '{{url('/forgot_pass')}}';
     _token = '{{Session::token()}}';
 </script>
@endsection