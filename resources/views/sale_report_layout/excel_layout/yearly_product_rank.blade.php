<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YEARLY RANKING REPORT</title>
</head>
<body>

<table>
    <tr>
        <td></td>
        <td></td>
        <td style="font-size: 50px;" colspan="12"><b><span
                        style="text-align: center;"><h1>INCEPTA PHARMACEUTICALS LTD.</h1></span></b></td>
    </tr>
</table>

<table id="tab_prds" class="table table-fixed-header table-fixed table-bordered table-striped "
       width="100%">

    <tbody style="white-space:nowrap;">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="background-color: #e6e676; text-align: center" >Brand Name</th>
            <th style="background-color: #2ce691 ; text-align: center" >Company</th>
            <th colspan="2" style="background-color: #E6B8B7; text-align: center">Quantity</th>
            <th colspan="2" style="background-color: #D8E4BC; text-align: center">Value
                <!-- (Crore) --></th>
            <th style="background-color: #CCC0DA ; text-align: center">Growth(Value Base)</th>
            <th colspan="2" style="background-color: #c8c8ff ; text-align: center"  >Rank(Value Base) </th>
            <th colspan="2"  style="background-color: #b9ecea ; text-align: center" >Contribution%</th>
            <th style="background-color: #FCD5B4 ; text-align: center" >Cumm%</th>
        </tr>
        <tr>
            <th style="background-color: #e6e676 ; text-align: center" class="text-center"></th>
            <th style="background-color: #2ce691 ; text-align: center" class="text-center" data-orderable="false"></th>
            <th style="background-color: #E6B8B7 ; text-align: center" class="text-center">{{$mon2}}</th>
            <th style="background-color: #E6B8B7 ; text-align: center" class="text-center">{{$mon1}}</th>

            <th style="background-color: #D8E4BC ; text-align: center;color: black" class="text-center">{{$mon2}}</th>
            <th style="background-color: #D8E4BC;color: black ; text-align: center" class="text-center">{{$mon1}}</th>

            <th style="background-color: #CCC0DA ; text-align: center" class="text-center">STATUS</th>

            <th style="background-color: #c8c8ff ; text-align: center" class="text-center">{{$mon2}}</th>
            <th style="background-color: #c8c8ff ; text-align: center" class="text-center">{{$mon1}}</th>

            <th style="background-color: #b9ecea ; text-align: center" class="text-center">{{$mon2}}</th>
            <th style="background-color: #b9ecea ; text-align: center" class="text-center">{{$mon1}}</th>

            <th style="background-color: #FCD5B4 ; text-align: center" class="text-center">{{$mon1}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($collections as $item => $value)
            <tr>
                <td style="width: 20%">{{ $value['brand_name'] }}</td>
                <td>{{ $value['company_name'] }}</td>
                <td>{{ $value['m2_qty'] }}</td>
                <td>{{ $value['m1_qty'] }}</td>
                <td>{{ $value['m2_val'] }}</td>
                <td>{{ $value['m1_val'] }}</td>
                <td>{{ $value['indicat'] }}</td>
                <td>{{ $value['m2_rp'] }}</td>
                <td>{{ $value['m1_rp'] }}</td>
                <td>{{ $value['m2_con'] }}</td>
                <td>{{ $value['m1_con'] }}</td>
                <td>{{ $value['cum'] }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <br><br>
    </tbody>
    <tfoot>

    </tfoot>
</table>

</body>
</html>