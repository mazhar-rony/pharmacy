@extends('layouts.backend.app')

@section('title', 'Sales & Profit')

@push('css')

<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

<!-- JQuery DataTable Css -->   
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-pink">
                    <h2 class="text-center">
                        SALES & PROFIT REPORT
                    </h2>
                </div>
                <div>
                    <form action="{{ route('admin.report.showSales') }}" method="POST">
                    @csrf
                        <div class="row clearfix" style="margin-top: 50px;">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="start_date">Start Date:</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="start_date" name="start_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                <label for="end_date">End Date:</label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="end_date" name="end_date" class="datepicker form-control" placeholder="Please choose a date..." required>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
                                <div class="form-group">
                                    <div class="form-line">
                                        <button type="submit" class="form-control btn bg-indigo waves-effect">
                                            <i class="material-icons">visibility</i>
                                            <span>SHOW</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>                                           
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="info-box bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">date_range</i>
                </div>
                <div class="content">
                    <div class="text">{{ $show_start_date }}</div>
                    <div class="number">FROM</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="info-box bg-light-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">date_range</i>
                </div>
                <div class="content">
                    <div class="text">{{ $show_end_date }}</div>
                    <div class="number">TO</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="info-box bg-teal hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL SALES</div>
                    <div class="number">{{ number_format(round($total_sales, 2), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL PROFIT</div>
                    <div class="number">{{ number_format(round($total_profit, 2), 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Sales</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Sales</th>
                                    <th>Profit</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($sales as $key=>$sale)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ Carbon\Carbon::parse($sale->date)->format('l d F Y') }}</td>                   
                                        <td>{{  number_format(round($sale->amount, 2), 2) }}</td> 
                                        <td>{{  number_format(round($sale->profit, 2), 2) }}</td>                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

<!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/widgets/infobox/infobox-2.js') }}"></script>  

<!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

@endpush