
<!doctype html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comparative Statement - {{ date('d-m-Y') }} </title>
    <style>
        table {
            border:1px solid #b3adad;
            border-collapse:collapse;
            padding:1px;
        }
        table th {
            border:1px solid #b3adad;
            padding:1px;
            background: #f0f0f0;
            color: #313030;
            font-size: 9px;
        }
        table td {
            border:1px solid #b3adad;
            text-align:center;
            padding:5px;
            background: #ffffff;
            color: #313030;
            font-size: 9px;
        }



        .page-break {
            page-break-after: always;
        }

    </style>

</head><body>

{{--main body start--}}

<header>
    <script type="text/php">
    if (isset($pdf)) {
        $x = 35;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
    </script>
    <span style="font-size: 12px">Req Date: {{\Carbon\Carbon::parse($rs_data[0]->req_date)->format('d F Y')}} </span>
</header>

<div class="row">



    <table>
        <thead>
        <tr>
            <th>Plant</th>
            <th>PR</th>
            <th>Material Code</th>
            <th>Material Name</th>
            <th>PR Quantity</th>
            <th>Quantity to<br> Purchase</th>
            <th>Supplier / Vendor</th>
            <th>Manufacturer</th>
            <th>Safety</th>
            <th>Mode of<br> shipment</th>
            <th>Last (Unit) <br> Price / KG</th>
            <th>New (Unit) <br> Price / KG</th>
            <th>Comment <br> (GM, SCM)</th>
            <th>Comment<br> (Vice Chairman)</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $rs_data as $d )
        <tr>
            <td>{{ $d->plant_id }}</td>
            <td>{{ $d->purch_req }}</td>
            <td>{{ $d->material }}</td>
            <td>{{ $d->material_desc }}</td>
            <td>{{ $d->pr_quantity }}</td>
            <td>{{ $d->qty_purchase }}</td>
            <td>{{ $d->supplier_vendor }}</td>
            <td>{{ $d->manufacturer }}</td>
            <td>{{ $d->safety }}</td>
            <td>{{ $d->mode_of_shipment }}</td>
            <td>{{ $d->last_unit_price_kg }}</td>
            <td>{{ $d->new_unit_per_kg }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>




</body></html>