<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-size: 15px;">

<div>
    <table  border="1">
        <thead>



        <tr style="border: 1px solid #000000;text-align: center;">
            <th>REQ_ID</th>
            <th>REQ_DATE</th>
            <th>EMP_ID</th>
            <th>EMP_NAME</th>
            <th>TERR_ID</th>
            <th>D_ID</th>
            <th>D_NAME</th>
            <th>DONATION_TYPE</th>
            <th>GROUP_BRAND_REGION_NAME</th>
            <th>GL</th>
            <th>COST_CENTER_ID</th>
            <th>SUB_COST_CENTER_ID</th>
            <th>BENEFICIARY_TYPE</th>
            <th>BENEFICIARY_GROUP</th>
            <th>PAYMENT_MODE</th>
            <th>PURPOSE</th>
            <th>FREQUENCY</th>
            <th>PAYMENT_MONTH</th>
            <th>PROPOSED_AMOUNT</th>
            <th>APPROVED_AMOUNT</th>
            <th>DOCTOR_ID</th>
            <th>DOCTOR_NAME</th>
            <th>NO_OF_PATIENT</th>
            <th>CONTACT_NO</th>
            <th>IN_FAVOUR_OF</th>
            <th>ADDRESS</th>
            <th>SPECIALITY</th>
            <th>COMMITMENT</th>
{{--            <th>STATUS</th>--}}
            <th>CREATE_USER</th>
            <th>CREATE_DATE</th>
            <th>AM_EMP_ID</th>
            <th>AM_NAME</th>
            <th>AM_CHECKED_DATE</th>
            <th>RM_EMP_ID</th>
            <th>RM_NAME</th>
            <th>RM_CHECKED_DATE</th>
            <th>BE_EMP_ID</th>
            <th>BE_NAME</th>
            <th>BE_CHECKED_DATE</th>
            <th>DSM_EMP_ID</th>
            <th>DSM_NAME</th>
            <th>DSM_CHECKED_DATE</th>
            <th>SM_EMP_ID</th>
            <th>SM_NAME</th>
            <th>SM_CHECKED_DATE</th>
            <th>SSD_EMP_ID</th>
            <th>SSD_NAME</th>
            <th>SSD_CHECKED_DATE</th>
            <th>GROUP_HEAD_EMP_ID</th>
            <th>GROUP_HEAD_EMP_NAME</th>
            <th>GROUP_HEAD_CHECKED_DATE</th>
            <th>GM_SALES_EMP_ID</th>
            <th>GM_SALES_EMP_NAME</th>
            <th>GM_SALES_CHECKED_DATE</th>
            <th>GM_MSD_EMP_ID</th>
            <th>GM_MSD_EMP_NAME</th>
            <th>GM_MSD_CHECKED_DATE</th>
            <th>REQ_ID</th>
            <th>SUMM_ID</th>
            <th>FI_DOC_NO</th>
            <th>FI_PROCESS</th>
            <th>BANK_ACCOUNT_NO</th>
            <th>D_ID</th>
            <th>SL</th>
            <th>REF_NO</th>
            <th>PRINT_BA</th>
            <th>PRINT_PL</th>
            <th>SEND_MAIL</th>
            <th>FI_PRINT</th>
            <th>CREATE_USER</th>
            <th>CREATE_DATE</th>
            <th>UPDATE_USER</th>
            <th>UPDATE_DATE</th>

            <th>BENEFICIARY_NAME</th>
            <th>BEN_BANK_ACCOUNT_NO</th>
            <th>BEN_BANK_ACCOUNT_NAME</th>
            <th>BEN_BANK_NAME</th>
            <th>BEN_BANK_BRANCH_NAME</th>
            <th>BEN_BANK_ROUTING_NO</th>


        </tr>

        </thead>
        <tbody>
        @foreach($rs_data as $rd)

            <tr>
                <td >{{ $rd->req_id }}</td>
                <td>{{ $rd->req_date }}</td>
                <td >{{ $rd->emp_id }}</td>
                <td>{{ $rd->emp_name }}</td>
                <td >{{ $rd->terr_id }}</td>
                <td>{{ $rd->d_id}}</td>
                <td >{{ $rd->d_name }}</td>
                <td>{{ $rd->donation_type }}</td>
                <td >{{ $rd->group_brand_region_name }}</td>
                <td>{{ $rd->gl }}</td>
                <td >{{ $rd->cost_center_id }}</td>
                <td >{{ $rd->sub_cost_center_id }}</td>
                <td>{{ $rd->beneficiary_type }}</td>
                <td>{{ $rd->beneficiary_group }}</td>
                <td >{{ $rd->payment_mode }}</td>
                <td>{{ $rd->purpose }}</td>
                <td >{{ $rd->frequency }}</td>
                <td>{{ $rd->payment_month }}</td>
                <td >{{ $rd->proposed_amount }}</td>
                <td>{{ $rd->approved_amount }}</td>
                <td >{{ $rd->doctor_id }}</td>
                <td >{{ $rd->doctor_name }}</td>
                <td>{{ $rd->no_of_patient }}</td>
                <td >{{ $rd->contact_no }}</td>
                <td>{{ $rd->in_favour_of }}</td>
                <td>{{ $rd->address }}</td>
                <td >{{ $rd->speciality }}</td>
                <td>{{ $rd->commitment }}</td>
{{--                <td >{{ $rd->status }}</td>--}}
                <td >{{ $rd->create_user }}</td>
                <td>{{ $rd->create_date }}</td>
                <td >{{ $rd->am_emp_id }}</td>
                <td>{{ $rd->am_name }}</td>
                <td >{{ $rd->am_checked_date }}</td>
                <td>{{ $rd->rm_emp_id }}</td>
                <td >{{ $rd->rm_name }}</td>
                <td>{{ $rd->rm_checked_date }}</td>
                <td >{{ $rd->be_emp_id }}</td>
                <td>{{ $rd->be_name }}</td>
                <td>{{ $rd->be_checked_date }}</td>
                <td >{{ $rd->dsm_emp_id }}</td>
                <td>{{ $rd->dsm_name }}</td>
                <td >{{ $rd->dsm_checked_date }}</td>
                <td>{{ $rd->sm_emp_id }}</td>
                <td >{{ $rd->sm_name }}</td>
                <td>{{ $rd->sm_checked_date }}</td>
                <td >{{ $rd->ssd_emp_id }}</td>
                <td>{{ $rd->ssd_name }}</td>
                <td>{{ $rd->ssd_checked_date }}</td>
                <td >{{ $rd->group_head_emp_id }}</td>
                <td>{{ $rd->group_head_emp_name }}</td>
                <td >{{ $rd->group_head_checked_date }}</td>
                <td>{{ $rd->gm_sales_emp_id }}</td>
                <td >{{ $rd->gm_sales_emp_name }}</td>
                <td>{{ $rd->gm_sales_checked_date }}</td>
                <td >{{ $rd->gm_msd_emp_id }}</td>
                <td>{{ $rd->gm_msd_emp_name }}</td>
                <td>{{ $rd->gm_msd_checked_date }}</td>

                <td >{{ $rd->req_id_bud}}</td>
                <td>{{ $rd->summ_id }}</td>
                <td >{{ $rd->fi_doc_no }}</td>
                <td>{{ $rd->fi_process }}</td>
                <td >{{ $rd->bank_account_no }}</td>
                <td >{{ $rd->d_id_bud }}</td>
                <td>{{ $rd->sl }}</td>
                <td >{{ $rd->ref_no }}</td>
                <td>{{ $rd->print_ba }}</td>
                <td>{{ $rd->print_pl }}</td>
                <td >{{ $rd->send_mail }}</td>
                <td>{{ $rd->fi_print }}</td>
                <td >{{ $rd->create_user_bud}}</td>
                <td>{{ $rd->create_date_bud}}</td>
                <td >{{ $rd->update_user }}</td>
                <td>{{ $rd->update_date }}</td>

                <td >{{ $rd->beneficiary_name }}</td>
                <td ><span>{{ $rd->bankaccno }}</span></td>
                <td >{{ $rd->beneficiary_bank_account_name }}</td>
                <td>{{ $rd->bankname }}</td>
                <td>{{ $rd->bankbranchname }}</td>
                <td >{{ $rd->bankroutingnum }}</td>


            </tr>
        @endforeach
        </tbody>

    </table>
</div>

</body>
</html>
