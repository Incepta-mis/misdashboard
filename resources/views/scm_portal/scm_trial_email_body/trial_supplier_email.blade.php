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
Dear Concern, <br> <br>

Please receive the Trial Report of your supplied sample.
<br>

{{ $msg }}

<br>
<br>

<table>
    <tr>
        <th>Product Name</th>
        <th>Item Description</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Supplier</th>
        <th>Concern Product</th>
    </tr>
    <tr>
        <td> {{ $product_name }}  </td>
        <td> {{ $item_desc }}  </td>
        <td> {{ $qty }}  </td>
        <td> {{ $uom }}  </td>
        <td> {{ $supplier_name }}  </td>
        <td> {{ $concern_product }}  </td>
    </tr>
</table>



<br>
<br>

<br>From,
<br>{{ $name }}
<br> Incepta Pharmaceuticals Ltd.
</body>
</html>


