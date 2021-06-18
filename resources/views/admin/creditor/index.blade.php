@extends('layouts.backend.app')

@section('title', 'Creditor')

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
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('admin.creditor.create') }}">
            <i class="material-icons">add</i>
            <span>Add New Creditor</span>
        </a>
    </div>
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL CREDITORS
                        <span class="badge bg-red">{{ $creditors->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Creditor Name</th>
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
                                    <th>ID</th>
                                    <th>Creditor Name</th>
                                    <th>Organization</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($creditors as $key=>$creditor)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $creditor->supplier->name }}</td>
                                        <td>{{ $creditor->supplier->organization }}</td>
                                        <td style="white-space:nowrap;">{{ Carbon\Carbon::parse($creditor->credit_date)->format('d-m-Y') }}</td>
                                        <td>{{ $creditor->description }}</td>
                                        <td>{{ number_format($creditor->credit_amount, 2) }}</td>
                                        <td><span class="badge bg-pink">{{ number_format($creditor->due, 2) }}</td>
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('admin.creditor.payment', $creditor->id) }}" class="btn btn-success waves-effect">
                                                <span>Payment </span><i class="material-icons">account_balance_wallet</i>
                                            </a>
                                            <a href="{{ route('admin.creditor.edit', $creditor->id) }}" class="btn btn-info waves-effect" {{ isset($creditor->purchase_id) ? 'disabled' : '' }}>
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button" {{ isset($creditor->purchase_id) ? 'disabled' : '' }}
                                                onclick="deleteCreditor({{ $creditor->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $creditor->id }}" method="POST"
                                                action="{{ route('admin.creditor.destroy', $creditor->id) }}"
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
        function deleteCreditor(id) {
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