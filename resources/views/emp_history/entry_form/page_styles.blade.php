<style>
    .panel-heading {
        padding: 5px 15px 2px 15px;
        margin-bottom: 0px;
    }

    /*.form-control {*/
    /*    border-radius: 0px;*/
    /*}*/

    .input-group-addon {
        border-radius: 0px;
    }

    .table > thead > tr > th {
        padding: 4px;
        font-size: 12px;
    }

    .table > tbody > tr > td {
        padding: 4px;
        font-size: 11px;
    }

    body {
        color: black !important;
    }

    .help-block {
        color: red;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    input[type=file]::-webkit-file-upload-button {
        width: 0;
        padding: 0;
        margin: 0;
        -webkit-appearance: none;
        border: none;
        border: 0px;
    }

    #msform {
        width: 400px;
        margin: 50px auto;
        text-align: center;
        position: relative;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    /*inputs*/
    #msform input, #msform textarea {
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 13px;
    }

    /*buttons*/
    #msform .action-button {
        width: 100px;
        background: #27AE60;
        font-weight: bold;
        color: darkred;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
    }

    /*headings*/
    .fs-title {
        font-size: 15px;
        text-transform: uppercase;
        color: #2C3E50;
        margin-bottom: 10px;
    }

    .fs-subtitle {
        font-weight: normal;
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        /*CSS counters to number the steps*/
        counter-reset: step;
    }

    #progressbar li {
        list-style-type: none;
        color: black;
        text-transform: uppercase;
        font-size: 9px;
        width: 33.33%;
        float: left;
        position: relative;
    }

    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 35px;
        line-height: 35px;
        display: block;
        font-size: 10px;
        color: #333;
        background: white;
        border-radius: 12px;
        margin: 0 auto 5px auto;
    }

    /*progressbar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: deeppink;
        position: absolute;
        left: -50%;
        top: 9px;
        z-index: -1; /*put it behind the numbers*/
    }

    #progressbar li:first-child:after {
        /*connector not needed before the first step*/
        content: none;
    }

    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: #27AE60;
        color: green;
    }

    .stepwizard-step p {
        margin-top: 0px;
        color: #666;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        /*opacity: 1 !important;
        filter: alpha(opacity=100) !important;*/
    }

    .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
        opacity: 1 !important;
        font-weight: bold;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-index: 0;
        left: 0;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    input {
        color: black
    }

    .education_table > tbody > tr > td {
        padding: 4px;
        font-size: 8px;
    }

    .education_table .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 5px 2px;
        font-size: 13px;
    }

    .employment_table > tbody > tr > td {
        padding: 4px;
        font-size: 8px;
    }

    .employment_table .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 5px 2px;
        font-size: 13px;
    }

    .swal2-popup .swal2-image {
        margin: 0px auto;
        max-width: 100%;
        height: 50px;
    }

    .swal2-popup.swal2-toast .swal2-title {
        font-size: 1.5em !important;
    }

    .swal2-popup.swal2-toast.swal2-show {
        border: 1px solid navajowhite;
    }

    .shadow {
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.2)
    }

    .swal2-popup .swal2-content{
        color: #D9534F;
    }

    #es_body{
        max-height: calc( 100vh - 200px );
        overflow-y: auto;

    }

    #es_body > table > tbody > row:hover{
        cursor: pointer;
    }

    .select2-container--default .select2-selection--single {
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .select2-container{
        width: 100% !important;
    }

    .btn-primary{
        background-color: #337AB7;
    }

    .table-responsive{
        overflow-x: unset !important;
    }

    .bootstrap-datetimepicker-widget{
        width: 320px!important;
    }

    .form-control:focus,.form-control-custom:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
    }

    .panel-body{
        padding: 15px 20px;
    }

    .panel-primary{
        border-left: 1px dashed #337AB7;
        border-right: 1px dashed #337AB7;
        border-bottom: 1px dashed #337AB7;
    }

    .form-control-custom {
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }

    fieldset.scheduler-border {
        border: 2px groove #337AC7 !important;
        padding: 0 1.2em 1.2em 1.2em !important;
        margin: 0 0 1.2em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.1em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        padding: 0 10px;
        border-bottom: none;
        color: #337AC7;
    }
</style>
