<link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
<link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-spinner.css')}}">

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

    tbody> tr>td:hover{
        cursor: pointer;
    }

    .wrapper{
        padding: 0px;
    }

    .col-md-12{
        padding: 0px;
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

   /* .modal-dialog {
        width: 80%;
        height: 100%;
        margin:  0 auto;
        padding: 0;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 0;
    }

    .modal-body {
        height: calc(100vh - 70px);
        /*height: 400px;*/
    }*/

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

    /*.card {
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
    }*/

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

    #pdf_content{
       background:url('{{url('public/site_resource/images/profile-load.svg')}}') center center no-repeat;
    }

    td{
        padding: 4px !important;;
    }

      /*grid card styles */

    .file-man-box {
        padding: 20px;
        border: 1px solid #e3eaef;
        border-radius: 5px;
        position: relative;
        margin-bottom: 20px
    }

    .file-man-box .file-close {
        color: #f1556c;
        position: absolute;
        line-height: 24px;
        font-size: 24px;
        right: 10px;
        top: 10px;
        visibility: hidden
    }

    .file-man-box .file-img-box {
        line-height: 60px;
        text-align: center
    }

    .file-man-box .file-img-box img {
        height: 64px
    }

    .file-man-box .file-download {
        font-size: 17px;
        color: #98a6ad;
        position: absolute;
        right: 10px;
        margin-top: 6px;
    }

    .file-man-box .file-download:hover {
        color: #313a46
    }

    .file-man-box .file-man-title {
        padding-right: 15px
    }

    .file-man-box:hover {
        -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
        box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
    }

    .file-man-box:hover .file-close {
        visibility: visible
    }
    .text-overflow {
        text-overflow: ellipsis;
        /*white-space: nowrap;*/
        display: block;
        width: 100%;
        overflow: hidden;
        height: 30px;
        overflow-y: scroll;
    }
    h5 {
        font-size: 11px;
    }

</style>
