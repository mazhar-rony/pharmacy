@extends('layouts.backend.app')

@section('title', 'Sales Details')

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
                        SALES DETAILS REPORT
                    </h2>
                </div>
                <div>
                    <form action="{{ route('admin.report.showSalesDetails') }}" method="POST">
                    @csrf
                        <div class="row clearfix" style="margin-top: 50px;">
                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <input type="checkbox" id="current_date" value="current" class="chk-col-pink form-control" checked />
                                    <label for="current_date">CURRENT DATE</label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <input type="checkbox" id="specific_date" value="specific" class="chk-col-pink form-control"/>
                                    <label for="specific_date">SPECIFIC DATE</label>
                                </div>
                            </div>
                            <div id="dateField" style="display:none" class="col-lg-3 col-md-3 col-sm-10 col-xs-10 col-sm-offset-1 col-xs-offset-1">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="date" name="date" class="datepicker form-control" placeholder="Please choose a date...">
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
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">date_range</i>
                </div>
                <div class="content">
                    <div class="text">{{ $show_date }}</div>
                    <div class="number">DATE</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                    <th>ID</th>
                                    <th>Invoice No</th>
                                    <th>Sales</th>
                                    <th>Profit</th>
                                    <th>Show Detail</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice No</th>
                                    <th>Sales</th>
                                    <th>Profit</th>
                                    <th>Show Detail</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($salesDetails as  $key=>$salesDetail)
                                    <tr>
                                        <td>{{ $key+1 }}</td>                          
                                        <td>{{ 'INV-' . $salesDetail->invoice_no }}</td>
                                        <td>{{ number_format(round($salesDetail->total_amount, 2), 2) }}</td>                   
                                        <td>{{ number_format(round($salesDetail->profit, 2), 2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.invoice.show', $salesDetail->id) }}" class="btn bg-indigo waves-effect" target="_blank">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>                                        
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
    
    <script>
<!-- Show Date Field for Specific Date-->

        $('#current_date').on('click', function(){
            if ($(this).prop('checked')){
                $('#dateField').hide();
                $('#date').prop('required', false);
                $('#specific_date').prop('checked', false); 
            } 
            else{
                $('#dateField').show();
                $('#date').prop('required', true);
                $('#specific_date').prop('checked', true);
            } 
        });

        $('#specific_date').on('click', function(){
            if ($(this).prop('checked')){
                $('#dateField').show();
                $('#date').prop('required', true);
                $('#current_date').prop('checked', false); 
            } 
            else{
                $('#dateField').hide();
                $('#date').prop('required', false);
                $('#current_date').prop('checked', true);
            } 
        });
    </script>
@endpush