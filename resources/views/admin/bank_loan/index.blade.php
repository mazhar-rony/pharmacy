@extends('layouts.backend.app')

@section('title', 'Bank')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('admin.account.create') }}">
            <i class="material-icons">add</i>
            <span>Add New Loan Account</span>
        </a>
    </div>
   
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL BANK LOANS
                        <span class="badge bg-red">{{ $accounts->count() }}</span
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>A/C No</th>
                                    <th>Bank</th>
                                    <th>Loan Date</th>
                                    <th>Loan Amount</th>
                                    <th>EMI Amount</th>
                                    <th>Total EMI</th>
                                    <th>EMI Done</th> 
                                    <th>Total Paid</th>                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>A/C No</th>
                                    <th>Bank</th>
                                    <th>Loan Date</th>
                                    <th>Loan Amount</th>
                                    <th>EMI Amount</th>
                                    <th>Total EMI</th>
                                    <th>EMI Done</th> 
                                    <th>Total Paid</th>                                   
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($accounts as $key=>$account)
                                    <tr>                          
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td>{{ $account->bank->name }}</td>
                                        <td>{{ $account->bank->loan_date }}</td>
                                        <td>{{ number_format($account->bank->loan_amount, 2) }}</td>
                                        <td>{{ number_format($account->bank->emi_amount, 2) }}</td>
                                        <td>{{ $account->bank->total_emi }}</td>
                                        <td>{{ $account->bank->emi_given }}</td>
                                        <td>{{ number_format($account->bank->total_paid, 2) }}</td>
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('admin.loan.transaction', $account->id) }}" class="btn btn-success waves-effect">
                                                <span>Transaction </span><i class="material-icons">account_balance_wallet</i>
                                            </a>
                                            <a href="{{ route('admin.loan.edit', $account->id) }}" class="btn btn-info waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button"
                                                onclick="deleteAccount({{ $account->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $account->id }}" method="POST"
                                                action="{{ route('admin.account.destroy', $account->id) }}"
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
        function deleteAccount(id) {
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