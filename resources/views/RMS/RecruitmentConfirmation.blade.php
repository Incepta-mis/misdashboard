@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')

    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: #000;
        }

        .sample_info_panel {
            position: -webkit-sticky;
            top: 0;
        }

        body {
            counter-reset: Serial;
        }


        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }

        input[list] {
            color: black;
            background-color: white;
        }

        .btn_form_below_save button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #77BB7A;
            color: #FFF;
            border: 1px solid #77BB7A;
        }

        .btn_form_below_update button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #08B2E0;
            color: #FFF;
            border: 1px solid #08B2E0;
        }

        .btn_form_below_refresh button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #F69448;
            color: #FFF;
            border: 1px solid #F69448;
        }

        .btn_form_below_save button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #021D07;
        }

        .btn_form_below_update button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #03244A;
        }

        .btn_form_below_refresh button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #F73203;
        }

        .select2-container {
            font-size: 10px;
        }

        .req_label_search {
            padding: 0;
            background-color: #374152;
            color: #FFF;
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;

        }

    </style>
@endsection

@section('right-content')

    <div class="row">
        <div class="wrapper_div">
            <div class="col-md-12 col-sm-12 sticky-top">
                <section class="sample_info_panel" id="data_table">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 sticky-top">
                            <section class="panel sample_info_panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary">
                                        Recruitment Confirmation
                                    </label>
                                </header>
                                <div class="panel-body" style="padding-bottom: 10px;">
                                    <div class="form-horizontal">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12">
                                                <form action="" class="form-horizontal" role="form">
                                                    <div class="row">
                                                        <div class="col-md-6"
                                                             style="padding: 0 5px; margin: 0 0 20px 0;">
                                                            <div class="col-md-8 req_label_search" style="    ">
                                                                <select name="search_rid"
                                                                        id="search_rid"
                                                                        class="form-control input-sm"
                                                                        style="font-size: 10px; height: 26px; padding: 0;">
                                                                    <option value="" selected disabled>Recruitment ID
                                                                    </option>
                                                                    @foreach($recruitment_id as $rid)
                                                                        <option value="{{$rid->recruitment_id}}">{{$rid->recruitment_id}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="input-group input-group-sm col-md-4">
                                                            <span class="input-group-btn">
                                                            <button class="btn btn-primary" id="btn_rid"
                                                                    name="btn_rid" type="button"
                                                                    style="height: 28px; padding: 0 8px; border-bottom-right-radius: 3px; border-top-right-radius: 3px;"><span
                                                                        style="padding: 0 6px"
                                                                        class="glyphicon glyphicon-search"
                                                                        aria-hidden="true">
                                                            </span>Search</button>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="recruitment_id"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Recruitment ID</b></label>
                                                                    <input type="text"
                                                                           name="recruitment_id"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="recruitment_id"
                                                                           autocomplete="off"
                                                                    readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="position"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Position</b></label>
                                                                    <input type="text"
                                                                           name="position"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="position"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="plant_name"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Plant Name</b></label>
                                                                    <input type="text"
                                                                           name="plant_name"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="plant_name"
                                                                           autocomplete="off"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="department_name"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Department Name</b></label>
                                                                    <input type="text"
                                                                           name="department_name"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="department_name"
                                                                           autocomplete="off"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="section_name"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Section Name</b></label>
                                                                    <input type="text"
                                                                           name="section_name"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="section_name"
                                                                           autocomplete="off"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12"
                                                             style="text-align: center; margin: 16px 0;">
                                                            <div class="btn-group btn-group-sm btn_form_below_save btn_form_below"
                                                                 role="group" aria-label="Third group">
                                                                <button style="padding: 1px 3px; height: 25px; width: 95px;"
                                                                        type="button" class="btn" id="btn_completed"><span
                                                                            style="padding: 0 3px;"
                                                                            class="fa fa-check"></span>Completed
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Organogram Image</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="" id="preview_img" width="200px">
                    <iframe id="viewer" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>

        $(document).ready(function () {

            //select 2 start
            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $('#search_rid').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#btn_rid").on('click', function () {

                var recruitment_id = $("#search_rid").val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/search_result_recruitment')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        recruitment_id: recruitment_id
                    },
                    success: function (response) {
                        var data_path = response.search_result_recruitment[0];

                        console.log(data_path);

                        var recruitment_id = data_path['recruitment_id'];
                        var plant_name = data_path['plant_name']+' | '+  data_path['plant_id'];
                        var department_name = data_path['dept_name'];
                        var section_name = data_path['section_name'];
                        var position = data_path['desig_name'];

                        $("#recruitment_id").val(recruitment_id);
                        $("#position").val(position);
                        $("#plant_name").val(plant_name);
                        $("#department_name").val(department_name);
                        $("#section_name").val(section_name);

                    }
                })


            });

            $("#btn_completed").on('click', function () {

                var recruitm_status = "COMPLETED";
                var recruitment_id = $("#recruitment_id").val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/complete_recruitment')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        'recruitm_status': recruitm_status,
                        'recruitment_id': recruitment_id
                    },
                    success: function (response) {
                        toastr.success("Recruitment Process Completed Successfully")
                        window.location.reload();
                    }
                })

            })

        })

    </script>

@endsection
