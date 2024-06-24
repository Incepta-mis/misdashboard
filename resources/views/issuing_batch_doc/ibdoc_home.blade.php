@extends('_layout_shared._master')
@section('title','Issuing Batch Doc.')
@section('styles')
    @include('issuing_batch_doc.ibdoc_styles')
@endsection
@section('right-content')
    <div ng-app="ibdoc">
        <toaster-container toaster-options="{'position-class': 'toast-top-center'}"></toaster-container>
        <div ng-controller="ibdController" class="col-md-12">
            <section class="panel">
                <header class="panel-heading ttn">
                    <span>Issuing of Batch Document</span>
                    <span class="pull-right" style="margin-right: 10px;">
                        <button title="Display As List" ng-style="viewType === 'L' && {'border':'1px solid blue'}"
                                ng-click="viewTypeChange('L')"><i class="fa fa-list"></i></button>
                        <button title="Display As Grid" ng-style="viewType === 'G' && {'border':'1px solid blue'}"
                                ng-click="viewTypeChange('G')"><i class="fa fa-th"></i></button>
                    </span>
                </header>
                <div class="panel-body ">
                    <div class="table-responsive custom-height">
                    <div class="table-responsive custom-height">
                        <div class="col-md-offset-2 col-md-8 badge badge-warning">
                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" ng-model="searchStr.text" class="form-control input-sm" placeholder="Search file/folder">
                            </div>
                        </div>
                        @include('issuing_batch_doc.ibdoc_fm_tab')
                        @include('issuing_batch_doc.ibdoc_grid_view')
                        <sarsha-spinner name="spinner2"></sarsha-spinner> 
                    </div>
                </div>
            </section>
            @include('issuing_batch_doc.ibdoc_modal_print_n')
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd. 
@endsection
@section('scripts')
    @include('issuing_batch_doc.ibdoc_scripts')
@endsection
