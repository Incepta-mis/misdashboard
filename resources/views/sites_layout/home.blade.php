@extends('_layout_shared._master')
@section('title','Home')
@section('right-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
                <div class="col-md-4 col-md-offset-4">
                {{Html::image('public/site_resource/images/incepta.png','',['width'=>'300px','height'=>'220px','display'=>'block','margin'=>'0 auto'])}}
                </div>
                <div class="col-md-12" style="text-align: center;font-weight: bold; font-size: 2em;">
                    <label>Management Information System</label>
                </div>
            </div>
            <!--</div>-->
        </div>
    </div>
@endsection
@section('footer-content')
    <label>Developed by Incepta | Department of Information Technology | Head Office</label>
@endsection