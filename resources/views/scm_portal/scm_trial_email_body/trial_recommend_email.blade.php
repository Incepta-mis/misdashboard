<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #0095ff;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
Dear Sir, <br> <br>

Please recommend the Trial Request Form No: <b><span style="font-size: 16px;">"{{ $ref_no }}"</span></b>
<br> <br>From the below Link:
<br>  {{ $local_url }}

{{--<br>Approved link is global {{ $url_link }} and--}}
{{--<br> local network link is {{ $local_url }}--}}
<br> <br>

<table>
    <tr>
        <th>Product Name</th>
        <th>Item Description</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Supplier</th>
        <th>Concern Product</th>
        <th>Remarks</th>
    </tr>
    <tr>
        <td> {{ $product_name }}  </td>
        <td> {{ $item_desc }}  </td>
        <td> {{ $qty }}  </td>
        <td> {{ $uom }}  </td>
        <td> {{ $supplier_name }}  </td>
        <td> {{ $concern_product }}  </td>
        <td> {{ $scm_remarks }}  </td>
    </tr>
</table>


<br>From,
<br>{{ $name }}
<br>SCM, Incepta HO
</body>
</html>


