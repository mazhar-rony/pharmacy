@extends('layouts.backend.app')

@section('title', 'Customer')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('user.customer.create') }}">
            <i class="material-icons">add</i>
            <span>Add New Customer</span>
        </a>
    </div>
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL CUSTOMERS
                        <span class="badge bg-red">{{ $customers->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer Name</th>
                                    <th>Organization</th>
                                    <th>Phone No</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer Name</th>
                                    <th>Organization</th>
                                    <th>Phone No</th>
                                    <th>Address</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($customers as $key=>$customer)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->organization }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
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