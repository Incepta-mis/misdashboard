<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>National Report</title>
</head>
<body>
<table border="1">
    <thead >
    <tr style="border: 1px solid #000000;background-color: #1da7ee;color:#ffffff;">
        <th>S.A.C</th>
        <th>DID</th>
        <th>NAME</th>
        <th>SAP_CODE</th>
        <th>P.GROUP</th>
        <th>P_CODE</th>
        <th>DESCRIPTION</th>
        <th>PACK_S</th>
        <th>T_P</th>
        <th>N_TGT</th>
        <th>DEPT_TGT</th>
        <th>VAL_N_TGT</th>
        <th>VAL_DEP_TGT</th>
        <th>N_T_TGT</th>
        <th>DEP_T_TGT</th>
        <th>QTY_SOLD</th>
        <th>QTY_INT</th>
        <th>QTY_EXP_SALE</th>
        <th>VAL_SOLD</th>
        <th>VAL_INT</th>
        <th>VAL_EXP_SALE</th>
        <th>INT_VDIS_AMT</th>
        <th>SOLD_VDIS_AMT</th>
        <th>QTY_STOCK</th>
        <th>ACH</th>
    </tr>
    </thead>
    <tbody >
    @foreach($rdata as $d)
        <tr style="border: 1px solid #000000;">
            <td>{{$d->sales_area_code}}</td>
            <td>{{$d->d_id}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->sap_code}}</td>
            <td>{{$d->p_group}}</td>
            <td>{{$d->p_code}}</td>
            <td>{{$d->description}}</td>
            <td>{{$d->pack_s}}</td>
            <td>{{$d->t_p}}</td>
            <td>{{$d->n_tgt}}</td>
            <td>{{$d->dept_tgt}}</td>
            <td>{{$d->val_n_tgt}}</td>
            <td>{{$d->val_dep_tgt}}</td>
            <td>{{$d->n_t_tgt}}</td>
            <td>{{$d->dep_t_tgt}}</td>
            <td>{{$d->qty_sold}}</td>
            <td>{{$d->qty_int}}</td>
            <td>{{$d->qty_exp_sale}}</td>
            <td>{{$d->val_sold}}</td>
            <td>{{$d->val_int}}</td>
            <td>{{$d->val_exp_sale}}</td>
            <td>{{$d->int_vdis_amt}}</td>
            <td>{{$d->sold_vdis_amt}}</td>
            <td>{{$d->qty_stock}}</td>
            <td>{{$d->ach}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>