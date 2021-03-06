@extends('layouts.backend.app')

@section('title', 'Debtor')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right" style="margin-bottom: 20px;">
    <button class="btn bg-teal btn-lg btn-block waves-effect" type="button" style="height: 50px; font-size: 14px; cursor: default; pointer-events: none;">Total Due 
        <span class="badge" style="font-size: 18px;">{{ number_format(($total_due->total_due), 2) }}</span>
    </button>
</div>
<div class="container-fluid">
    {{-- <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('user.debtor.create') }}">
            <i class="material-icons">add</i>
            <span>Add New Debtor</span>
        </a>
    </div> --}}
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL DEBTORS
                        <span class="badge bg-red">{{ $debtors->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Debtor Name</th>
                                    <th>Organization</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Debtor Name</th>
                                    <th>Organization</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($debtors as $key=>$debtor)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $debtor->customer->name }}</td>
                                        <td>{{ $debtor->customer->organization }}</td>
                                        <td style="white-space:nowrap;">{{ Carbon\Carbon::parse($debtor->debit_date)->format('d-m-Y') }}</td>
                                        <td style="white-space:nowrap;">{{ $debtor->description }}</td>
                                        <td>{{ number_format($debtor->debit_amount, 2) }}</td>
                                        <td><span class="badge bg-pink">{{ number_format($debtor->due, 2) }}</td>
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('user.debtor.payment', $debtor->id) }}" class="btn btn-success waves-effect">
                                                <span>Payment </span><i class="material-icons">account_balance_wallet</i>
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
@endpush