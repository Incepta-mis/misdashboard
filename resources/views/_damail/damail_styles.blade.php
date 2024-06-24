<link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-spinner.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select.min.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select2.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/selectize.default.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" />

<style>
    body {
        color: #000000;
    }

    .ttn{
        text-transform: none;
    }

    [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
        display: none !important;
    }

    input[type='checkbox']:hover{
        cursor: pointer;
    }

    .custom-height{
        height: calc(100vh - 153px)!important;
    }

    body{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .shadow {
        -moz-box-shadow:    inset 0 0 10px #000000;
        -webkit-box-shadow: inset 0 0 10px #000000;
        box-shadow:         inset 0 0 10px #000000;
    }

    .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0 auto;
        padding: 0;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 0;
    }

    .modal-body {
        height: calc(100vh - 120px);
        /*height: 400px;*/
    }

    textarea{
        resize: vertical;
    }

    .text{
        font-weight: bold;
    }

    .trow:hover{
        font-weight: bold;
        color: #0f81cc;
    }

    .modal-header{
        background-color: #0f81cc;
    }

    #the-canvas {
        border: 1px solid black;
        direction: ltr;
    }

    .card {
        background: #fff;
        border-radius: 2px;
    }

    .card-1 {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }

    .card-grid{
        background: #fff;
        border-radius: 2px;
        margin: 5px;
        /*max-height: 160px;*/
        width: 160px;
        padding: 15px;
        text-align: center;
        display: inline-block;
    }

    .card-grid-1{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    .card-grid-1:hover{
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        cursor: pointer;
    }

    .card-1:hover {
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }

    hr{
        margin: 0;
    }
    .lbl_text{
        word-wrap: break-word;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 7vh!important;
    }

    .select2 > .select2-choice.ui-select-match {
        /* Because of the inclusion of Bootstrap */
        height: 29px;
    }

    .selectize-control > .selectize-dropdown {
        top: 36px;
    }

    .select2-results .select2-highlighted {
        background: #2a6496;
        color: #fff;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container-multi .select2-choices{
        border-radius: 4px 4px 0 0;
    }

    .weather-forecast li {
        float: none;
        min-width: 14.2857%;
        width: auto;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 4px;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .progress{
        margin-bottom: 0;
        border-radius: 0;
    }

    li.list-item{
        padding: 10px;
        margin: 5px 15px 5px 15px;
        border: 1px solid gainsboro;
    }

    li.list-item:hover{
        cursor: pointer;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        border: 1px solid #657b9a;
    }

    .table > thead > tr > th {
        padding: 4px;
        font-size: 12px;
    }

    .table > tbody > tr > td {
        padding: 4px;
        font-size: 11px;
    }

    .pagination{
        margin: 0;
    }
	
	.btn-success{
        background-color: #657b9a !important;
        border-color: #657b9a !important;
    }

    .dark-turquoise-bg {
    background: #657b9a !important;
}



</style>
