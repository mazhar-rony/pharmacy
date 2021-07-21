@extends('layouts.backend.app')

@section('title', 'Purchase')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('user.purchase.create') }}">
            <i class="material-icons">add</i>
            <span>Create New Purchase</span>
        </a>
    </div>
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{-- ALL PURCHASES --}}
                        PURCHASES of LAST 7 DAYS & ALL DUES
                        <span class="badge bg-red">{{ $purchases->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Purchase No</th>
                                    <th>Supplier</th>
                                    <th>Organization</th>
                                    <th>Date</th>
                                    {{-- <th>Amount</th>
                                    <th>Discount</th> --}}
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    {{--  <th>Created_by</th>  --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Purchase No</th>
                                    <th>Supplier</th>
                                    <th>Organization</th>
                                    <th>Date</th>
                                    {{-- <th>Amount</th>
                                    <th>Discount</th> --}}
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    {{--  <th>Created_by</th>  --}}
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($purchases as $key=>$purchase)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $purchase->purchase_no }}</td> 
                                        <td>{{ $purchase->supplier->name }}</td>
                                        <td>{{ $purchase->supplier->organization }}</td>
                                        <td style="white-space:nowrap;">{{ Carbon\Carbon::parse($purchase->date)->format('d-m-Y') }}</td>   
                                        {{-- <td>{{ number_format(round($purchase->amount, 2), 2) }}</td>
                                        <td>{{ number_format(round($purchase->discount, 2), 2) }}</td> --}}
                                        <td>{{ number_format(round($purchase->total_amount, 2), 2) }}</td>                                        
                                        <td><span class="badge {{ $purchase->is_paid == TRUE ? 'bg-green' : 'bg-pink' }}">{{ $purchase->is_paid == TRUE ? 'Paid' : 'Due' }}</span></td>
                                        {{--  <td>{{ $purchase->user->name }}</td>   --}}
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('user.purchase.show', $purchase->id) }}" class="btn btn-success waves-effect" target="_blank" data-toggle="tooltip" data-placement="top" title="Show">
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
    <!-- #END# Exportable Table -->
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

<!-- Show Tooltop on Buttons -->
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush