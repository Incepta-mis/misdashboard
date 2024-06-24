<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="{{url('public/site_resource/images/incepta.png')}}" type="image/png">

    <title>@yield('title','title')</title>

    {{--<link href="{{url('public/site_resource/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>--}}


    {{Html::style('public/site_resource/css/bulma.css')}}
    {{Html::style('public/site_resource/css/bulma-doc.css')}}

    <style>
        .table .is-selected-fatema {
            background-color: #ced104;
        }
        .table .is-selected-masroor {
            background-color: #9ad104;
        }
        .table .is-selected-raqib {
            background-color: #00d1b2;
        }
        .column{
            border: 2px solid black;
        }
    </style>
</head>
<body>



<section class="section">
    <div class="container">
        


            <div class="column">
                <p class="bd-notification is-info">Sale Report</p>
            </div>

            <table class="table is-responsive">
    <thead>
    <tr>
        <th><abbr title="Position">No</abbr></th>
        <th>Mudules Name</th>
        <th>Done By</th>
        <th>Used Tables Name</th>
    </tr>
    </thead>

    <tbody>
    <tr class="is-selected-fatema">
        <th>1</th>
        <td> <strong>History Channel Base</strong>   </td>
        <td><strong>Fatema</strong> </td>
        <td><span style="color: blue">MIS.MONTH_WISE_SALES_REPORT,<br> MIS.SUMMARY_OF_SALES</span></td>
    </tr>
    <tr class="is-selected-fatema">
        <th>2</th>
        <td> <strong>History Company Base</strong></td>
        <td><strong>Fatema</strong> </td>
        <td><span style="color: blue">MIS.all_company_sales, <br>MIS.all_company_sales_channel_wise,<br> MIS.depot_team_wise_sales_history</span></td>
    </tr>

    <tr class="is-selected-raqib">
        <th>3</th>
        <td> <strong>Team Growth %</strong></td>
        <td><strong>Raqib</strong> </td>
        <td><span style="color: blue"></span></td>
    </tr>

    <tr class="is-selected-fatema">
        <th>4</th>
        <td> <strong>GM & SM Achievement%</strong></td>
        <td><strong>Fatema</strong> </td>
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-fatema">
        <th>5</th>
        <td> <strong>RM Achievement%</strong></td>
        <td><strong>Fatema</strong> </td>
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-fatema">
        <th>6</th>
        <td> <strong>Performance</strong></td>
        <td><strong>Fatema</strong> </td>
        <td><span style="color: blue"></span></td>
    </tr>

    <tr class="is-selected-masroor">
        <th>7</th>
        <td> <strong>Performance</strong></td>
        <td><strong>Masroor</strong> </td>
        <td><span style="color: blue"></span></td>
    </tr>

    <tr class="is-selected-masroor">
        <th>8</th>
        <td> <strong>SM Wise Sales</strong></td>
        <td><strong>Masroor</strong> </td>
        
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-masroor">
        <th>9</th>
        <td> <strong>RM Wise Sales</strong></td>
        <td><strong>Masroor</strong> </td>
       
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-masroor">
        <th>10</th>
        <td> <strong>RM Detail</strong></td>
        <td><strong>Masroor</strong> </td>
        
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-masroor">
        <th>11</th>
        <td> <strong>Depot Wise Sales</strong></td>
        <td><strong>Masroor</strong> </td>
       
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-fatema">
        <th>12</th>
        <td> <strong>DHK GRP & MKT Product</strong></td>
        <td><strong>Fatema</strong> </td>
        
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-fatema">
        <th>13</th>
        <td> <strong>NATIONAL QTY TRG ARH</strong></td>
        <td><strong>Fatema</strong> </td>
        
        <td><span style="color: blue"></span></td>
    </tr>
    <tr class="is-selected-raqib">
        <th>14</th>
        <td> <strong>Depot Wise Product Rank</strong></td>
        <td><strong>Raqib</strong> </td>
        
        <td><span style="color: blue"></span></td>
    </tr>
    </tbody>
</table>

        <div class="column">
            <p class="bd-notification is-success">Expense</p>
        </div>
        <table class="table is-responsive">
            <thead>
            <tr>
                <th><abbr title="Position">No</abbr></th>
                <th>Mudules Name</th>
                <th>Done By</th>
                <th>Used Tables Name</th>
            </tr>
            </thead>

            <tbody>
            <tr class="is-selected-fatema">
                <th>1</th>
                <td> <strong>UPLOAD EXPORT SALES DATA</strong>   </td>
                <td><strong>Fatema</strong> </td>
               
                <td><span style="color: blue">MIS.UPLOAD_EXPORT_SALES_DATA</span></td>
            </tr>
            <tr class="is-selected-fatema">
                <th>1</th>
                <td> <strong>UPLOAD INST SALES DATA</strong>   </td>
                <td><strong>Fatema</strong> </td>
                
                <td><span style="color: blue">MIS.UPLOAD_INST_SALES_DATA</span></td>
            </tr>


            </tbody>
        </table>
        <div class="column">
            <p class="bd-notification is-warning">Employee Competency</p>
        </div>
            <table class="table is-responsive">
                <thead>
                <tr>
                    <th><abbr title="Position">No</abbr></th>
                    <th>Mudules Name</th>
                    <th>Done By</th>
                    <th>Used Tables Name</th>
                </tr>
                </thead>

                <tbody>
                <tr class="is-selected-fatema">
                    <th>1</th>
                    <td> <strong> User Manual</strong>   </td>
                    <td><strong>Fatema</strong> </td>
                  
                    <td><span style="color: blue">MIS.UPLOAD_EXPORT_SALES_DATA</span></td>
                </tr>
                <tr class="is-selected-fatema">
                    <th>1</th>
                    <td> <strong>Rating Definition</strong>   </td>
                    <td><strong>Fatema</strong> </td>
                   
                    <td><span style="color: blue">MIS.UPLOAD_INST_SALES_DATA</span></td>
                </tr>
                <tr class="is-selected-raqib">
                    <th>1</th>
                    <td> <strong>EMPLOYEE SUPERVISOR</strong>   </td>
                    <td><strong>Raqib</strong> </td>
                    
                    <td><span style="color: blue"></span></td>
                </tr>
                <tr class="is-selected-fatema">
                    <th>1</th>
                    <td> <strong>EMPLOYEE RATING ENTRY FORM</strong>   </td>
                    <td><strong>Fatema</strong> </td>
                    
                    <td><span style="color: blue">MIS.UPLOAD_INST_SALES_DATA</span></td>
                </tr>
                <tr class="is-selected-raqib">
                    <th>1</th>
                    <td> <strong>EMPLOYEE RATING GRAPH</strong>   </td>
                    <td><strong>Raqib</strong> </td>
                    
                    <td><span style="color: blue"></span></td>
                </tr>
                </tbody>
            </table>


        <div class="column">
            <p class="bd-notification is-danger">Data Upload</p>
        </div>
            <table class="table is-responsive">
                <thead>
                <tr>
                    <th><abbr title="Position">No</abbr></th>
                    <th>Mudules Name</th>
                    <th>Done By</th>
                    <th>Used Tables Name</th>
                </tr>
                </thead>

                <tbody>
                <tr class="is-selected-fatema">
                    <th>1</th>
                    <td> <strong>UPLOAD EXPORT SALES DATA</strong>   </td>
                    <td><strong>Fatema</strong> </td>
                   
                    <td><span style="color: blue">MIS.UPLOAD_EXPORT_SALES_DATA</span></td>
                </tr>
                <tr class="is-selected-fatema">
                    <th>1</th>
                    <td> <strong>UPLOAD INST SALES DATA</strong>   </td>
                    <td><strong>Fatema</strong> </td>
                   
                    <td><span style="color: blue">MIS.UPLOAD_INST_SALES_DATA</span></td>
                </tr>


                </tbody>
                </table>

        </div>
    </section>
</body>
</html>