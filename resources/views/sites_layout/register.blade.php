@extends('_layout_login._login_register_master')
@section('title','Register')
@section('body-content')
    <form class="form-signin" action="{{url('register_user')}}">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">Registration</h1>
            {{Html::image('site_resource/images/incepta.png','',['width'=>'260px','height'=>'150px'])}}
        </div>

        <div class="login-wrap">
            <p>Enter your personal details below</p>
            <input type="text" autofocus="" placeholder="Full Name" class="form-control">
            <input type="text" autofocus="" placeholder="Address" class="form-control">
            <input type="text" autofocus="" placeholder="Email" class="form-control">
            <input type="text" autofocus="" placeholder="City/Town" class="form-control">
            <div class="radios">
                <label for="radio-01" class="label_radio col-lg-6 col-sm-6">
                    <input type="radio" checked="" value="1" id="radio-01" name="sample-radio"> Male
                </label>
                <label for="radio-02" class="label_radio col-lg-6 col-sm-6">
                    <input type="radio" value="1" id="radio-02" name="sample-radio"> Female
                </label>
            </div>

            <p> Enter your account details below</p>
            <input type="text" autofocus="" placeholder="User Name" class="form-control">
            <input type="password" placeholder="Password" class="form-control">
            <input type="password" placeholder="Re-type Password" class="form-control">
            <label class="checkbox">
                <input type="checkbox" value="agree this condition"> I agree to the Terms of Service and Privacy Policy
            </label>
            <button type="submit" class="btn btn-lg btn-login btn-block">
                <i class="fa fa-check"></i>
            </button>

            <div class="registration">
                Already Registered.
                <a href="{{url('/')}}" class="">
                    Login
                </a>
            </div>

        </div>

    </form>
@endsection
