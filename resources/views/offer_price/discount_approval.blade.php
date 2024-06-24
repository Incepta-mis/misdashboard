@extends('_layout_shared._master')
@section('title','Discount Approval')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        /*.refresh {*/
        /*    margin-right: 50px;*/
        /*}*/

        body {
            color: #000;
        }
        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/

        }
        /*#9b8a30*/
        .table-cell-edit{
            background-color: #F3E7A7;
        }
        .edit_percent{
            background-color: lightblue;
        }
        .edit_price{
            background-color: lightcyan;
        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Discount Approval
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">

                                    @if(Auth::user()->desig === 'All'||Auth::user()->desig === 'HO')

                                    @endif

                                <button type="button"  class="refresh btn btn-warning" style="float:right">Refresh</button>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>


    <div class="row" id="detail-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th rowspan="2" style="text-align: center"><input type="checkbox" id="selectAll"><span> </span>All</th>
                                    <th rowspan="2">proposal</th>
                                    <th rowspan="2">inv_id</th>
                                    <th rowspan="2">ch_id</th>
                                    <th rowspan="2">ch_name</th>
                                    <th rowspan="2">d_id</th>
                                    <th rowspan="2">p_code</th>
                                    <th rowspan="2">product</th>
                                    <th rowspan="2">t_p</th>
                                    <th rowspan="2">vat</th>
                                    <th >offered</th>
                                    <th>offered</th>
                                    <th>quantity</th>
                                    <th>total_sales_at</th>
                                    <th>total</th>
                                    <th rowspan="2">total_blp</th>
                                    <th>profit_loss</th>
                                    <th>profit_loss</th>
                                    <th>margin%</th>

                                    <th rowspan="2" display="none">raw_cost</th>
                                    <th rowspan="2" display="none">pack_cost</th>
                                    <th rowspan="2" display="none">labour</th>
                                    <th rowspan="2"  display="none">qc</th>
                                    <th rowspan="2" display="none">process_loss</th>
                                    <th rowspan="2" display="none">job_work</th>
                                    <th rowspan="2" display="none">blp</th>
                                    <th rowspan="2" display="none">blp_vat</th>

                                </tr>
                                <tr>
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
                                    <th>percent</th>
                                    <th>price</th>
                                    <th>in pac</th>
                                    <th>offer_price</th>
                                    <th>variable_cost</th>
{{--                                    <th></th>--}}
                                    <th>at_vc</th>
                                    <th>at_blp</th>
                                    <th>on TP</th>






                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;">

                                </tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    <script type="text/javascript">

        det_table = "{{url('offer/table_data')}}";
        verify_and_update = "{{url('offer/verify_and_update')}}";
        discount_blp_data = "{{url('offer/discount_blp_data')}}";
        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";
        _csrf_token = '{{csrf_token()}}';
        let table2;
        var verifydata = [];


        $(document).ready(function (){
            $("#loader").show();

           $.ajax({
                url: det_table,
                method: "post",    // change here for post method
                dataType: 'json',

                data: {
                    _token: _csrf_token

                },

                success: function (resp) {

                    console.log(resp);

                    $("#loader").hide();

                    $("#detail_list").DataTable().destroy();

                    table2 = $("#detail_list").DataTable({
                        data: resp,
                        dom: 'Bfrtip',

                        buttons: [
                            {
                                text: '<i class="btn btn-info btn-xs accept"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Approve </i>',
                                action: function ( e, dt, node, config ) {

                                    let insertdata = [];

                                    function getAllValues() {

                                        $("#detail_list tbody tr.selected ").each(function() {

                                            let inv_id = $(this).find("td").eq(2).html();
                                            let ch_id = $(this).find("td").eq(3).html();
                                            let p_code = $(this).find("td").eq(6).html();

                                            let offered_percent = $(this).find("td").eq(10).html();
                                            let offered_price = $(this).find("td").eq(11).html();
                                            let total_sales_at_offer_price = $(this).find("td").eq(13).html();
                                            let profit_loss_at_vc = $(this).find("td").eq(16).html();
                                            let profit_loss_at_blp = $(this).find("td").eq(17).html();
                                            let margin = $(this).find("span:first").text();

                                            let allValues = {};

                                            allValues['inv_id'] = inv_id;
                                            allValues['ch_id'] = ch_id;
                                            allValues['p_code'] = p_code;
                                            allValues['offered_percent'] = offered_percent;
                                            allValues['offered_price'] = offered_price;
                                            allValues['total_sales_at_offer_price'] = total_sales_at_offer_price;
                                            allValues['profit_loss_at_vc'] = profit_loss_at_vc;
                                            allValues['profit_loss_at_blp'] = profit_loss_at_blp;
                                            allValues['margin'] = margin;

                                            // if(input_flag){
                                                insertdata.push(allValues);
                                            // }
                                        })
                                        console.log(insertdata);

                                    }

                                    getAllValues();

                                        // console.log(verifydata);

                                        if (insertdata.length !== 0) {

                                            console.log('Entered in the loop');

                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    dataType: 'json',
                                                    data: {
                                                        // verifyData: verifydata,
                                                        verifyData: JSON.stringify(insertdata),
                                                        _token: _csrf_token},
                                                    url: verify_and_update,
                                                    beforeSend: function(){
                                                        // Show image container
                                                        $("#loader_submit").show();
                                                    },
                                                    success: function (response) {

                                                        console.log(response);
                                                        toastr.success("Updated successfully");


                                                    },
                                                    complete:function(data){
                                                        // Hide image container
                                                        $("#loader_submit").hide();
                                                    },
                                                    error: function (err) {
                                                        console.log(err);
                                                        toastr.error("Error updating");
                                                    }
                                                });

                                        }

                                }
                            }
                        ],

                        columns: [

                            {data: null},
                            {data: "proposal_no"},
                            {data: "inv_id"},
                            {data: "ch_id"},
                            {data: "ch_name"},
                            {data: "d_id"},
                            {data: "p_code"},
                            {data: "product_name"},
                            {data: "t_p"},
                            {data: "vat"},
                            {data: "offered_percent",  className:"edit_percent"},
                            {data: "offered_price", className:"edit_price"},
                            {data: "qty_pak"},
                            {data: "total_sales_at_offer_price", className: "table-cell-edit"},
                            {data: "total_variable_cost"},
                            {data: "total_blp"},
                            {data: "profit_loss_at_vc",className: "table-cell-edit"},
                            {data: "profit_loss_at_blp", className: "table-cell-edit"},
                            // {data: "margin", className: "table-cell-edit"},

                            {
                                data: null,
                                "render": function (row) {
                                    if (row.margin >= 0)
                                        return '<span style="background-color: greenyellow" >' + row.margin + '</span>';
                                    else
                                        return '<span style="background-color: orangered" >' + row.margin + '</span>';

                                }
                            },

                            {data: "raw_cost"},
                            {data: "pack_cost"},
                            {data: "labour"},
                            {data: "qc"},
                            {data: "process_loss"},
                            {data: "job_work"},
                            {data: "blp"},
                            {data: "blp_vat"}

                        ],


                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        "scrollY": "450px",
                        "scrollX": true,
                        "scrollCollapse": true,
                        "paging": false,
                        fixedHeader: true,

                        // "autoWidth": false,
                        columnDefs: [{
                            orderable: false,
                            className: 'select-checkbox',
                            targets: 0,
                            render: function (data, type, full, meta) {

                                return '';
                            }
                        },
                            // { width: "5%", targets: 3 },
                            {
                                "targets": [ 19,20,21,22,23,24,25,26 ],
                                "visible": false
                            }
                        ],

                        select: {
                            style: 'multi',
                            selector: 'td:first-child'
                        },
                        order: [
                            [1, 'asc']
                        ],
                        // info: false,
                        searching:true


                    });



                    $("#detail-body").show();

                    table2.columns.adjust().responsive.recalc();
                },
                error: function (err) {
                    // console.log(err);
                    $("#loader").hide();
                    $("#detail-body").show();
                }
            });

            $('.refresh').on('click',function () {
                console.log('hey');
                $.ajax({
                    url: det_table,
                    method: "post",    // change here for post method
                    dataType: 'json',

                    data: {
                        _token: _csrf_token

                    },

                    success: function (resp) {

                        console.log(resp);

                        $("#loader").show();

                        $("#detail-body").hide();

                        $("#detail_list").DataTable().destroy();

                        table2 = $("#detail_list").DataTable({
                            data: resp,
                            dom: 'Bfrtip',

                            buttons: [
                                {
                                    text: '<i class="btn btn-info btn-xs accept"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Approve </i>',
                                    action: function ( e, dt, node, config ) {

                                        let insertdata = [];

                                        function getAllValues() {

                                            $("#detail_list tbody tr.selected ").each(function() {

                                                let inv_id = $(this).find("td").eq(2).html();
                                                let ch_id = $(this).find("td").eq(3).html();
                                                let p_code = $(this).find("td").eq(6).html();

                                                let offered_percent = $(this).find("td").eq(10).html();
                                                let offered_price = $(this).find("td").eq(11).html();
                                                let total_sales_at_offer_price = $(this).find("td").eq(13).html();
                                                let profit_loss_at_vc = $(this).find("td").eq(16).html();
                                                let profit_loss_at_blp = $(this).find("td").eq(17).html();
                                                let margin = $(this).find("span:first").text();

                                                let allValues = {};

                                                allValues['inv_id'] = inv_id;
                                                allValues['ch_id'] = ch_id;
                                                allValues['p_code'] = p_code;
                                                allValues['offered_percent'] = offered_percent;
                                                allValues['offered_price'] = offered_price;
                                                allValues['total_sales_at_offer_price'] = total_sales_at_offer_price;
                                                allValues['profit_loss_at_vc'] = profit_loss_at_vc;
                                                allValues['profit_loss_at_blp'] = profit_loss_at_blp;
                                                allValues['margin'] = margin;

                                                // if(input_flag){
                                                insertdata.push(allValues);
                                                // }
                                            })
                                            console.log(insertdata);

                                        }

                                        getAllValues();

                                        // console.log(verifydata);

                                        if (insertdata.length !== 0) {

                                            console.log('Entered in the loop');

                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });

                                            $.ajax({
                                                type: "POST",
                                                dataType: 'json',
                                                data: {
                                                    // verifyData: verifydata,
                                                    verifyData: JSON.stringify(insertdata),
                                                    _token: _csrf_token},
                                                url: verify_and_update,
                                                beforeSend: function(){
                                                    // Show image container
                                                    $("#loader_submit").show();
                                                },
                                                success: function (response) {

                                                    console.log(response);
                                                    toastr.success("Updated successfully");


                                                },
                                                complete:function(data){
                                                    // Hide image container
                                                    $("#loader_submit").hide();
                                                },
                                                error: function (err) {
                                                    console.log(err);
                                                    toastr.error("Error updating");
                                                }
                                            });

                                        }

                                    }
                                }
                            ],

                            columns: [

                                {data: null},
                                {data: "proposal_no"},
                                {data: "inv_id"},
                                {data: "ch_id"},
                                {data: "ch_name"},
                                {data: "d_id"},
                                {data: "p_code"},
                                {data: "product_name"},
                                {data: "t_p"},
                                {data: "vat"},
                                {data: "offered_percent",  className:"edit_percent"},
                                {data: "offered_price", className:"edit_price"},
                                {data: "qty_pak"},
                                {data: "total_sales_at_offer_price", className: "table-cell-edit"},
                                {data: "total_variable_cost"},
                                {data: "total_blp"},
                                {data: "profit_loss_at_vc",className: "table-cell-edit"},
                                {data: "profit_loss_at_blp", className: "table-cell-edit"},
                                // {data: "margin", className: "table-cell-edit"},

                                {
                                    data: null,
                                    "render": function (row) {
                                        if (row.margin >= 0)
                                            return '<span style="background-color: greenyellow" >' + row.margin + '</span>';
                                        else
                                            return '<span style="background-color: orangered" >' + row.margin + '</span>';

                                    }
                                },

                                {data: "raw_cost"},
                                {data: "pack_cost"},
                                {data: "labour"},
                                {data: "qc"},
                                {data: "process_loss"},
                                {data: "job_work"},
                                {data: "blp"},
                                {data: "blp_vat"}

                            ],


                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            "scrollY": "450px",
                            "scrollX": true,
                            "scrollCollapse": true,
                            "paging": false,
                            fixedHeader: true,

                            // "autoWidth": false,
                            columnDefs: [{
                                orderable: false,
                                className: 'select-checkbox',
                                targets: 0,
                                render: function (data, type, full, meta) {

                                    return '';
                                }
                            },
                                // { width: "5%", targets: 3 },
                                {
                                    "targets": [ 19,20,21,22,23,24,25,26 ],
                                    "visible": false
                                }
                            ],

                            select: {
                                style: 'multi',
                                selector: 'td:first-child'
                            },
                            order: [
                                [1, 'asc']
                            ],
                            // info: false,
                            searching:true


                        });


                        $("#loader").hide();
                        $("#detail-body").show();

                        table2.columns.adjust().responsive.recalc();
                    },
                    error: function (err) {
                        // console.log(err);
                        $("#loader").hide();
                        $("#detail-body").show();
                    }
                });
            });

            // new DataTable('#detail_list', {
            //     initComplete: function () {
            //         this.api()
            //             .columns()
            //             .every(function () {
            //                 let column = this;
            //                 let title = column.footer().textContent;
            //
            //                 // Create input element
            //                 let input = document.createElement('input');
            //                 input.placeholder = title;
            //                 column.footer().replaceChildren(input);
            //
            //                 // Event listener for user input
            //                 input.addEventListener('keyup', () => {
            //                     if (column.search() !== this.value) {
            //                         column.search(input.value).draw();
            //                     }
            //                 });
            //             });
            //     }
            // });

            $('#selectAll').on('click',function () {
                in_favour_of_flag = false;

                if ( table2.rows( '.selected' ).any() ) {
                    table2.rows().deselect();
                    $("#selectAll").prop("checked", false);
                    // subtracting all the checked values
                }else {
                    table2.rows().select();
                }
            });


            // Inline editing
            let oldValue = null;

            $(document).on('dblclick', '.edit_percent', function(){

                oldValue = $(this).html();
                $(this).removeClass('edit_percent');	// to stop from making repeated request
                $(this).html('<input type="text" style="width:150px;" class="update_percent" value="'+ oldValue +'" />');
                $(this).find('.update_percent').focus();


            });

            $(document).on('dblclick', '.edit_price', function(){

                oldValue = $(this).html();
                $(this).removeClass('edit_price');	// to stop from making repeated request
                $(this).html('<input type="text" style="width:150px;" class="update_price" value="'+ oldValue +'" />');
                $(this).find('.update_price').focus();


            });

            $(document).on('blur', '.update_percent', function(){
                let elem    = $(this);
                let newValue 	= $(this).val();
                // console.log(newValue);

                if(newValue != oldValue)
                {

                    let tp = parseFloat($(this).closest("tr").find('td').eq(8).html().trim())  ;
                    let vat = parseFloat($(this).closest("tr").find('td').eq(9).html().trim())  ;
                    let quantity= $(this).closest("tr").find('td').eq(12).html().trim() ;
                    let percent= newValue ;
                    let price= parseFloat(((tp+vat)-(tp*percent/100)).toFixed(2)) ;
                    let raw_cost = parseFloat(table2.row( $(this).closest("tr")).data()['raw_cost'])  ;
                    let pack_cost = parseFloat(table2.row( $(this).closest("tr")).data()['pack_cost'])  ;
                    let labour = parseFloat(table2.row( $(this).closest("tr")).data()['labour'])  ;
                    let qc = parseFloat(table2.row( $(this).closest("tr")).data()['qc'])  ;
                    let process_loss = parseFloat(table2.row( $(this).closest("tr")).data()['process_loss'])  ;
                    let job_work = parseFloat(table2.row( $(this).closest("tr")).data()['job_work'])  ;
                    let blp = parseFloat(table2.row( $(this).closest("tr")).data()['blp'])  ;
                    let blp_vat = parseFloat(table2.row( $(this).closest("tr")).data()['blp_vat'])  ;
                    let tsop = (quantity*price).toFixed(2);
                    let plvc = (tsop - (raw_cost+pack_cost+labour+qc+process_loss+job_work)*quantity).toFixed(2);
                    console.log(plvc);
                    let plblp = (tsop - (quantity*blp_vat)).toFixed(2) ;
                    console.log(plblp);
                    let margin = (((price - (vat+blp))/tp)*100).toFixed(2);
                    console.log(margin);
                    $(this).closest("tr").find('td').eq(11).html(price);
                    $(this).closest("tr").find('td').eq(13).html(tsop);

                    $(this).closest("tr").find('td').eq(16).html(plvc);
                    $(this).closest("tr").find('td').eq(17).html(plblp);
                    $(this).closest("tr").find('td').eq(18).html(margin);

                    if(margin>=0){
                        $(this).closest("tr").find('td').eq(18).css("background-color","greenyellow");
                    }
                    else{
                        $(this).closest("tr").find('td').eq(18).css("background-color","orangered");
                    }

                            $(elem).parent().addClass('edit_percent');
                            $(elem).parent().html(newValue);

                }
                else
                {
                    $(elem).parent().addClass('edit_percent');
                    $(this).parent().html(newValue);
                }
            });


            $(document).on('blur', '.update_price', function(){
                let elem    = $(this);
                let newValue 	= $(this).val();
                console.log(newValue);


                if(newValue != oldValue)
                {
                    console.log("old value is : " +oldValue + " And New value is :" + newValue);

                    let tp = parseFloat($(this).closest("tr").find('td').eq(8).html().trim())  ;
                    let vat = parseFloat($(this).closest("tr").find('td').eq(9).html().trim())  ;
                    let quantity= $(this).closest("tr").find('td').eq(12).html().trim() ;
                    let price= newValue ;
                    let percent= parseFloat((((tp+vat)-price)/tp*100).toFixed(2))  ;
                    let raw_cost = parseFloat(table2.row( $(this).closest("tr")).data()['raw_cost'])  ;
                    let pack_cost = parseFloat(table2.row( $(this).closest("tr")).data()['pack_cost'])  ;
                    let labour = parseFloat(table2.row( $(this).closest("tr")).data()['labour'])  ;
                    let qc = parseFloat(table2.row( $(this).closest("tr")).data()['qc'])  ;
                    let process_loss = parseFloat(table2.row( $(this).closest("tr")).data()['process_loss'])  ;
                    let job_work = parseFloat(table2.row( $(this).closest("tr")).data()['job_work'])  ;
                    let blp = parseFloat(table2.row( $(this).closest("tr")).data()['blp'])  ;
                    let blp_vat = parseFloat(table2.row( $(this).closest("tr")).data()['blp_vat'])  ;
                    let tsop = (quantity*price).toFixed(2);
                    let plvc = (tsop - (raw_cost+pack_cost+labour+qc+process_loss+job_work)*quantity).toFixed(2);
                    console.log(plvc);
                    let plblp = (tsop - (quantity*blp_vat)).toFixed(2) ;
                    console.log(plblp);
                    let margin = (((price - (vat+blp))/tp)*100).toFixed(2);
                    console.log(margin);
                    $(this).closest("tr").find('td').eq(10).html(percent);
                    $(this).closest("tr").find('td').eq(13).html(tsop);

                    $(this).closest("tr").find('td').eq(16).html(plvc);
                    $(this).closest("tr").find('td').eq(17).html(plblp);
                    $(this).closest("tr").find('td').eq(18).html(margin);

                    if(margin>=0){
                        $(this).closest("tr").find('td').eq(18).css("background-color","greenyellow");
                    }
                    else{
                        $(this).closest("tr").find('td').eq(18).css("background-color","orangered");
                    }

                            $(elem).parent().addClass('edit_price');
                            $(elem).parent().html(newValue);

                }
                else
                {
                    $(elem).parent().addClass('edit_price');
                    $(this).parent().html(newValue);
                }
            });



        });

        $('.toggle-btn ').on('click', function(){
            table2.columns.adjust().responsive.recalc();
        });


    </script>

@endsection