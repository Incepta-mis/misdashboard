<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Verify-Approve Report</title>
</head>
<body>
   <table>
       <tbody>
       <tr>
           <td colspan="2"></td>
           <td colspan="6" style="text-align: center;color: #285e8e;"><h2>Incepta Pharmaceuticals Ltd.</h2></td>
           <td colspan="2"></td>
       </tr>
       <tr>
           <td colspan="2"></td>
           <td colspan="6" style="text-align: center;">40 Shahid Tajuddin Ahmed Sarani Tejgaon I/A</td>
           <td colspan="2"></td>
       </tr>
       <tr>
           <td colspan="2"></td>
           <td colspan="6" style="text-align: center;">Dhaka-1208</td>
           <td colspan="2"></td>
       </tr>
       <tr>
           <td colspan="2" style="text-align: center;font-weight: bold;">Region: {{$region}}</td>
           <td colspan="6" style="text-align: center;font-weight: bold;">Expense Month: {{\Carbon\Carbon::parse($emonth)->format('F-Y')}}</td>
           <td colspan="2" style="text-align: right;font-weight: bold;">Report Date: {{\Carbon\Carbon::now()->format('d-m-Y')}}</td>
       </tr>
       </tbody>
   </table>
   <table border="1">
       <tbody>
         <tr  style="border: 1px solid #000000;">
             <td style="text-align: center;font-weight: bold;">EXP MONTH</td>
             <td style="text-align: center;font-weight: bold;">DEPOT NAME</td>
             <td style="text-align: center;font-weight: bold;">EMP ID</td>
             <td style="text-align: center;font-weight: bold;">EMP NAME</td>
             <td style="text-align: center;font-weight: bold;">DESIG</td>
             <td style="text-align: center;font-weight: bold;">TEAM</td>
             <td style="text-align: center;font-weight: bold;">TERR ID</td>
             <td style="text-align: center;font-weight: bold;">VERIFIED STATUS</td>
             <td style="text-align: center;font-weight: bold;">APPROVED STATUS</td>
             <td style="text-align: center;font-weight: bold;">TOTAL AMOUNT</td>
         </tr>
         @foreach($rdata as $data)
         <tr  style="border: 1px solid #000000;">
             <td>{{\Carbon\Carbon::parse($data->exp_month)->format('d-m-Y')}}</td>
             <td>{{$data->depot_name}}</td>
             <td>{{$data->eid}}</td>
             <td>{{$data->emp_name}}</td>
             <td>{{$data->desig}}</td>
             <td>{{$data->team}}</td>
             <td>{{$data->terr}}</td>
             <td>{{$data->verified_status}}</td>
             <td>{{$data->approved_status}}</td>
             <td @if($data->total_amount > 10000) style="background-color: #a6e1ec;" @endif>{{number_format($data->total_amount)}}</td>
         </tr>
         @endforeach
       </tbody>
       <tfoot>
         <tr  style="border: 1px solid #000000;">
             <td colspan="9" style="text-align: right;font-weight: bold;">Total</td>
             @php $total = 0;
               foreach ($rdata as $dt){
                   $total += $dt->total_amount;
               }
             @endphp
             <td style="font-weight: bold;text-align: right;">{{number_format($total)}}</td>
         </tr>
       </tfoot>
   </table>

</body>
</html>