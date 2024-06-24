@extends('_layout_shared._master')
@section('title','EMPLOYEE"S HISTORY FORM HR')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}"/>
    <link rel="stylesheet" href="{{url('public/site_resource/css/bs-stepper.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/toast/toastr.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/select2/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{url('public/site_resource/css/salert/sweetalert2.min.css')}}"/>
    <link rel="stylesheet" href="{{url('public/site_resource/spinner-btn/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/select2-bootstrap.min.css')}}">
    @include('emp_history.entry_form.page_styles')
@endsection
@section('right-content')

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div style="float: right">
                </div>  
                <section class="panel shadow" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            
                                <span>
                                    EMPLOYEE'S HISTORY FORM HR
                                </span>
                            <br>
                            
                        </label>

                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label>Select Employee:</label>
                                        <div class="form-group">
                                            <div class="input-group select2-bootstrap-prepend ">
                                                <select type="text" id="employee_list" class="form-control">
                                                </select>
                                                <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_display" type="button">Display</button>
                              </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

        @endsection
        @section('footer-content')
        {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script src="{{url('public/site_resource/spinner-btn/spin.min.js')}}"></script>
    <script src="{{url('public/site_resource/spinner-btn/ladda.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/toast/toastr.min.js')}}"></script>
    <script src="{{url('public/site_resource/select2/select2.min.js')}}"></script>

    <script>

        var ehf_hr = '{{url('ehf/emp_history_admin')}}';
        var currentQuery;

        $('#employee_list').select2({
            placeholder: 'Select Employee ID',
            delay: 250,
            minimumInputLength: 5,
            ajax: {
                url: '{{url('ehf/search_employee_id')}}',
                data: function (params) {
                    var query = {
                        search: params?.term?.toUpperCase()
                    }
                    return query;
                }
            },
            datatype:'json'
        }).on('select2:closing', function (e) {
            // Preserve typed value
            currentQuery = $('.select2-search input').prop('value');
        }).on('select2:open', function (e) {
            // Fill preserved value back into Select2 input field and trigger the AJAX loading (if any)
            $('.select2-search input').val(currentQuery).trigger('change').trigger("input");
        });

        $('#btn_display').on('click', function () {

            console.log('clicked');
            var sample = $('#employee_list :selected').text().trim();
            var new_string = sample.substring(0,sample.indexOf("|") );
            console.log(sample);
            console.log(new_string);

            window.location = ehf_hr + "/" + new_string ;

        });


    </script>
    {{Html::script('public/site_resource/js/bootstrap-fileupload.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}
    {{Html::script('public/site_resource/js/salert/swal_toast.js')}}
    <!--spinner-->
    {{Html::script('public/site_resource/js/fuelux/js/spinner.min.js')}}
    {{Html::script('public/site_resource/js/spinner-init.js')}}
    <!--bootstrap input mask-->
    {{Html::script('public/site_resource/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}


    <script>


    </script>

@endsection

