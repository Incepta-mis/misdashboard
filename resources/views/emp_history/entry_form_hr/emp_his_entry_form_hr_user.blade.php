@extends('_layout_shared._master')
@section('title','EMPLOYEE"S PERSONAL HISTORY FORM')
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
    @if($exist)
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel shadow" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary"><span>EMPLOYEE'S PERSONAL HISTORY FORM</span> <br>
                            <span style="font-size:13px;color:darkred;text-transform:none;">(Please Attempt each portion clearly,completely and concisely)
                            </span>
                        </label>
                        <div class="stepwizard">
                            <div class="stepwizard-row setup-panel">
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                                    <p>
                                        <small>Page 1|4</small>
                                    </p>
                                </div>
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-2" type="button" class="btn btn-default btn-circle"
                                    >2</a>
                                    <p>
                                        <small>Page 2|4</small>
                                    </p>
                                </div>
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-3" type="button" class="btn btn-default btn-circle"
                                    >3</a>
                                    <p>
                                        <small>Page 3|4</small>
                                    </p>
                                </div>
                                <div class="stepwizard-step stepwizard-step-final col-xs-3">
                                    <a href="#step-4" type="button" class="btn btn-default btn-circle"
                                    >4</a>
                                    <p>
                                        <small>Page 4|4</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="panel-body">
                        <!-- page one -->
                    @include('emp_history.entry_form_hr.page_one_hr')
                    <!-- page two -->
                    @include('emp_history.entry_form_hr.page_two')
                    <!-- page three -->
                    @include('emp_history.entry_form_hr.page_three')
                    <!-- page four -->
                        @include('emp_history.entry_form_hr.page_four_hr')
                    </div>
                </section>
            </div>
        </div>
        @include('emp_history.emp_his_modal_error_hr')
        @include('emp_history.es_modal')

    @else
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel shadow" id="data_table">
                    <div class="panel-body">
                        <p class="alert alert-warning text-warning text-center">
                            <i class="fa fa-info-circle"></i>
                            Your Employee ID is not found in the system.<b> Please contact with HRD</b>
                        </p>
                    </div>
                </section>
            </div>

        </div>
        @endif
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


        $('.thumbnail').html("<img style='max-height:150px;max-width: 150px' " +
            "src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'  />");
        var route_config = {
            routes: {
                pageone_url: "{{url('ehf/postPageoneForm_hr')}}",
                pagetwo_url: "{{url('ehf/postPagetwoForm_hr')}}",
                pagethree_url: "{{url('ehf/postPagethreeForm_hr')}}",
                pagefour_url: "{{url('ehf/postPagefourForm_hr')}}",
                preview_url: '{{url('ehf/emp_final_pdfform_preview_hr')}}',
                final_pdf_url: '{{url('ehf/emp_final_pdfform_hr')}}',
                loader: '{{url('public/site_resource/images/profile-load.svg')}}',
                mail_url: '{{url('ehf/send_mail_hr')}}'
            }
        };
        var user = {
            grade: '{{$login_moreinfo[0]->egrade}}',
            grades: ['H00', 'H01', 'H02', 'H03', 'H04-1', 'H04-2', 'M01-1', 'M01-2', 'M02', 'M03', 'M04', 'M05', 'L01', 'L02', 'L03', 'L04', 'L05'],
            nominees: ['Father', 'Mother', 'Brother', 'Sister', 'Son', 'Daughter', 'Husband', 'Wife']
        };

        var education = {
            university: <?php echo json_encode($edu_all_uni);?>,
            subject: <?php echo json_encode($edu_all_sub);?>
        };

        var desigList = {
            items: <?php echo json_encode($emp_desig_list); ?>
        };

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

    {{Html::script('public/site_resource/js/custom/emp_history_js/script_emphis_entry_pageone.js?ts='.time().'')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/script_emphis_entry_pagetwo.js?ts='.time().'')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/script_emphis_entry_pagethree.js?ts='.time().'')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/script_emphis_entry_pagefour_hr.js?ts='.time().'')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/page_validation.js?ts='.time().'')}}
    <script>
        company_name = '{{$company_name[0]->com_name}}';
    </script>
    {{--    <script src="http://malsup.github.com/jquery.form.js"></script>--}}
    @include('emp_history.entry_form_hr.page_script_hr')

@endsection

