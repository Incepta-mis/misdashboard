<!DOCTYPE html>
<html lang="en"><head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style> .table > thead > tr > th {
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

        .tbs {
            position: relative;
        }

        .rel {
            position: relative;
        }

        .borderless td, .borderless th {
            border: none;
        }</style>
</head><body>
<div class="container tbs"><h2>INCEPTA PHARMACEUTICALS LTD.</h2>
    <p>TRAVEL DETAILS</p>
    <table class="table table-bordered">{{-- <thead> <tr> <th>Firstname</th> <th>Lastname</th> <th>Email</th> </tr> </thead>--}}
        <tbody>
        <tr>
            <td>Name</td>
            <td colspan="2">{{ $user[0]->emp_name }}</td>
            <td>Emp Code</td>
            <td colspan="2">{{ $user[0]->emp_id }}</td>
        </tr>
        <tr>
            <td>Designation</td>
            <td colspan="2">{{ $user[0]->desig_name }}</td>
            <td>Department</td>
            <td colspan="2">{{ $user[0]->dept_name }}</td>
        </tr>
        <tr>
            <td>Passport Number</td>
            <td>{{ $user[0]->passport_no }}</td>
            <td>Issue Date</td>
            <td>{{ date('d-m-Y', strtotime($user[0]->date_of_issue)) }}</td>
            <td>Expiry Date</td>
            <td>{{ date('d-m-Y', strtotime($user[0]->date_of_expiry))   }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td colspan="2">{{ $empEmail }}</td>
            <td>Mobile No.</td>
            <td colspan="2">{{ $empMobile }}</td>
        </tr>
        <tr>
            <td>GL</td>
            <td colspan="2">{{ $user[0]->gl_code }}</td>
            <td>Cost Center</td>
            <td colspan="2"> {{ $user[0]->cost_center_id }} - {{ $user[0]->cost_center_name }}</td>
        </tr>
        <tr>
            <td>Travel Type</td>
            <td colspan="2">{{ $user[0]->travel_type }}</td>
            <td>Purpose.</td>
            <td colspan="2">{{ $user[0]->purpose }}</td>
        </tr>
        <tr>
            <td>Hotel Rent Born By</td>
            <td colspan="2"><label class="checkbox-inline">@if($user[0]->hotel_company) <input type="checkbox"
                                                                                               checked="checked"
                                                                                               value="Company">
                    Company @else <input type="checkbox" value="Company">Company @endif</label><label
                        class="checkbox-inline">@if($user[0]->hotel_vendor) <input type="checkbox" checked="checked"
                                                                                   value="Vendor">Vendor @else <input
                            type="checkbox" value="Company">Vendor @endif</label><label
                        class="checkbox-inline">@if($user[0]->hotel_others) <input type="checkbox" checked="checked"
                                                                                   value="Others">Others @else <input
                            type="checkbox" value="Others">Others @endif</label></td>
            <td>Meal Expense Born By</td>
            <td colspan="2"><label class="checkbox-inline">@if($user[0]->meal_company) <input type="checkbox"
                                                                                              checked="checked"
                                                                                              value="Company">
                    Company @else <input type="checkbox" value="Company">Company @endif</label><label
                        class="checkbox-inline">@if($user[0]->meal_vendor) <input type="checkbox" checked="checked"
                                                                                  value="Vendor">Vendor @else <input
                            type="checkbox" value="Company">Vendor @endif</label><label
                        class="checkbox-inline">@if($user[0]->meal_others) <input type="checkbox" checked="checked"
                                                                                  value="Others">Others @else <input
                            type="checkbox" value="Others">Others @endif</label></td>
        </tr>
        <tr>
            <td>Transport Born By</td>
            <td colspan="2"><label class="checkbox-inline">@if($user[0]->transport_company) <input type="checkbox"
                                                                                                   checked="checked"
                                                                                                   value="Company">
                    Company @else <input type="checkbox" value="Company">Company @endif</label><label
                        class="checkbox-inline">@if($user[0]->transport_vendor) <input type="checkbox" checked="checked"
                                                                                       value="Vendor">Vendor @else
                        <input type="checkbox" value="Company">Vendor @endif</label><label
                        class="checkbox-inline">@if($user[0]->transport_others) <input type="checkbox" checked="checked"
                                                                                       value="Others">Others @else
                        <input type="checkbox" value="Others">Others @endif</label></td>
            <td>Document NO</td>
            <td colspan="2">{{ $user[0]->document_no }}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center"><b>PERIOD & ROUTE DETAILS</b></td>
        </tr>
        <tr>{{-- @foreach(explode('#', $user[0]->location) as $info) {{ $info }}--}}
            <td colspan="6" style="padding-bottom: 0px; padding-top: 0px;">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" style="text-align: center"><strong>DATE</strong></td>
                        <td colspan="4" style="text-align: center"><strong>ROUTE</strong></td>
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align: center"><strong>FROM</strong></td>
                        <td colspan="1" style="text-align: center"><strong>TO</strong></td>
                        <td colspan="2" style="text-align: center"><strong>FROM</strong></td>
                        <td colspan="2" style="text-align: center"><strong>TO</strong></td>
                    </tr>@foreach($user as $info)
                        <tr>
                            <td colspan="1">{{ date('d-m-Y',strtotime($info->from_time)) }}</td>
                            <td colspan="1">{{ date('d-m-Y',strtotime($info->to_time)) }}</td>
                            <td colspan="2">{{ $info->from_loc }}</td>
                            <td colspan="2">{{ $info->to_loc }}</td>
                        </tr> @endforeach</table>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center"><b>EXPENSE GL,CC & CWIP ASSET RELATED INFO</b></td>
        </tr>
        <tr>
            <td>MRP NO</td>
            <td colspan="2">{{ $user[0]->mrp_no }}</td>
            <td>DATE</td>
            <td colspan="2"> @if(!empty($user[0]->mrp_date))) {{ date('d-m-Y', strtotime($user[0]->mrp_date)) }} @endif</td>
        </tr>
        <tr>
            <td>SAP PR NO</td>
            <td colspan="2">{{ $user[0]->sap_pr_no }}</td>
            <td>DATE</td>
            <td colspan="2">@if(!empty($user[0]->sap_pr_date)))  {{ date('d-m-Y', strtotime($user[0]->sap_pr_date)) }} @endif</td>
        </tr>
        <tr>
            <td>L/C NO</td>
            <td colspan="2">{{ $user[0]->lc_no }}</td>
            <td>DATE</td>
            <td colspan="2">@if(!empty($user[0]->lc_date))) {{  date('d-m-Y', strtotime($user[0]->lc_date)) }} @endif</td>
        </tr>
        <tr>
            <td>PO NO</td>
            <td colspan="2">{{ $user[0]->po_no }}</td>
            <td>DATE</td>
            <td colspan="2"> @if(!empty($user[0]->po_date))) {{ date('d-m-Y', strtotime($user[0]->po_date)) }} @endif</td>
        </tr>
        <tr>
            <td>CWIP ASSET NO</td>
            <td colspan="2">{{ $user[0]->cwip_asset_no }}</td>
            <td>CWIP ASSET NAME</td>
            <td colspan="2">{{ $user[0]->cwip_asset_name }}</td>
        </tr>
        </tbody>
    </table>
    <table class="table borderless" style="padding-top: 40px;">
        <tbody>
        <tr>
            <td></td>
            <td colspan="2">@if($user[0]->plant_id == 1000)
                    <div style=" float: left;"><img src="{{url('public/site_resource/images/Md_Mahbubul Karim.png')}}"
                                                    width="80px" height="40px" style="padding-left: 20px;"><br>---------------------------<br><b>Recommended
                            By</b><br>Department Head<br></div> @else
                    <div style=" float: left;"><img src="{{url('public/site_resource/images/Md_Mahbubul Karim.png')}}"
                                                    width="80px" height="40px" style="padding-left: 20px;"><br>---------------------------<br><b>Recommended
                            By</b><br>COO<br></div> @endif</td>
            <td></td>
            <td colspan="2">
                <div style="float: right;"><img src="{{url('public/site_resource/images/Md_Mahbubul Karim.png')}}"
                                                width="80px" height="40px" style="padding-left: 20px; "><br>---------------------------<br><b>Approved
                        By</b><br>Chairman / Vice Chairman<br></div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body></html>
