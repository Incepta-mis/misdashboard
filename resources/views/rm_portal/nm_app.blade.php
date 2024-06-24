@extends('_layout_shared._master')
@section('title','Notice Manager App Download')
@section('styles')
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

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
            color: black;
        }

        .table > tbody > tr > td.txt {
            padding: 4px;
            font-size: 1.0em;
            vertical-align: middle;
        }

        .panel-heading {
            text-transform: none;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-offset-3 col-sm-6 col-md-6">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Application Download
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive">

                        <table class="table table-striped table-condensed table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">File Name</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($app as $a)
                                <tr class="text-center">
                                    <td class="txt text-primary"><i class="fa fa-android"></i> <b>{{$a->des}}</b></td>
                                    <td>
                                        <a href="{{$a->link}}">
                                            <button class="btn btn-sm btn-default btn-primary">
                                                <i class="fa fa-download"></i> <b>Download</b>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">
                                        No File Available
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </section>
        </div>

    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
