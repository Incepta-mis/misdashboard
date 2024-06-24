<div class="row" style="font-size: 12px;">
    <div class="col-xs-2">
    </div>
    <div class="col-xs-6">
        <center>
            <span style="font-weight: bold;font-size: 16px;color: #285e8e;">Incepta Pharmaceuticals Ltd.</span><br>
            Doctors Requisition For Personal Use<br>
            SAMPLE
            <br>
            <br>
        </center>
    </div>

    <div class="row" style=" margin-left: 3%;margin-right: 3%;">
        <span><</span><br>
    </div>

    <div class="col-xs-3">
    </div>
</div>
<br>
<div class="row" style=" font-size: 11px;margin-left: 1%;margin-right: 1%;">
    <table border="1" width="100%">
        <tr style="border: 1px solid #000000;">
            <td style="text-align: center;font-weight: bold;">Req ID</td>
            <td style="text-align: center;font-weight: bold;">Item ID</td>
            <td style="text-align: center;font-weight: bold;">Item Name</td>
            <td style="text-align: center;font-weight: bold;">Quantity</td>
            <td style="text-align: center;font-weight: bold;">Unit Price</td>
            <td style="text-align: center;font-weight: bold;">Total</td>
        </tr>
        <tbody>
        @forelse($rdata as $data)
            <tr style="border: 1px solid #000000;">
                <td style="text-align: center">{{$data->req_id}}</td>
                <td style="text-align: center">{{$data->item_id}}</td>
                <td style="text-align: center">{{$data->item_name}}</td>
                <td style="text-align: center">{{$data->qty}}</td>
                <td style="text-align: center">{{$data->unit_price}}</td>
                <td style="text-align: center">{{$data->tot_value}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align: center;font-size: 15px;">
                    No Data found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>