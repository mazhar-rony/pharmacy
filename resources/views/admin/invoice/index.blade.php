@extends('layouts.backend.app')

@section('title', 'Invoice')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('admin.invoice.create') }}">
            <i class="material-icons">add</i>
            <span>Create New Invoice</span>
        </a>
    </div>
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL INVOICES
                        <span class="badge bg-red">{{ $invoices->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Total Amount</th>
                                    {{--  <th>Paid</th>
                                    <th>Due</th>  --}}
                                    <th>Profit</th>
                                    <th>Status</th>
                                    <th>Created_by</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Total Amount</th>
                                    {{--  <th>Paid</th>
                                    <th>Due</th>  --}}
                                    <th>Profit</th>
                                    <th>Status</th>
                                    <th>Created_by</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($invoices as $key=>$invoice)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $invoice->invoice_no }}</td> 
                                        <td>Take Away Customer</td>
                                        <td>{{ $invoice->date }}</td>   
                                        <td>{{ $invoice->amount }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ number_format(round($invoice->total_amount, 2), 2) }}</td>
                                        {{--  <td>{{ $invoice->paid }}</td> 
                                        <td>{{ $invoice->due }}</td>  --}}
                                        <td>{{ $invoice->profit }}</td>
                                        <td><span class="badge {{ $invoice->status == TRUE ? 'bg-pink' : 'bg-green' }}">{{ $invoice->status == TRUE ? 'Pending' : 'Paid' }}</span></td>
                                        <td>{{ $invoice->created_by }}</td> 
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('admin.invoice.edit', $invoice->id) }}" class="btn btn-info waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button"
                                                onclick="deleteInvoice({{ $invoice->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $invoice->id }}" method="POST"
                                                action="{{ route('admin.invoice.destroy', $invoice->id) }}"
                                                style="display: none;">
                                                    @csrf
                                                    @method('DELETE')

                                            </form>
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

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
        function deleteInvoice(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {

                  event.preventDefault();
                  document.getElementById('delete-form-' + id).submit();
                    
                  swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                  )
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                  )
                }
              })
        }
    </script>
@endpush