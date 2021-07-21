<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            {{--  <img src="{{ Storage::disk('public')->url('profile/'.Auth::user()->image) }}" width="48" height="48" alt="User" />  --}}
            <img src="{{ Storage::disk('public')->url('user/'.Auth::user()->image) }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    {{-- <li><a href="{{ Auth::user()->role->id == 1 ? route('admin.settings') : route('author.settings') }}">
                        <i class="material-icons">person</i>Profile</a>
                    </li> --}}
                    {{-- <li><a href="{{ Auth::user()->role->id == 2 ? route('user.profile.edit', Auth::user()->id) : route('admin.profile.edit', Auth::user()->id) }}">
                        <i class="material-icons">face</i>Profile</a>
                    </li> --}}
                    <li><a href="{{ Auth::user()->role->id == 2 ? route('user.profile.edit') : route('admin.profile.edit') }}">
                        <i class="material-icons">face</i>Profile</a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ Auth::user()->role->id == 2 ? route('user.password.edit') : route('admin.password.edit') }}">
                        <i class="material-icons">vpn_key</i>Change Password &emsp;&emsp;</a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>Sign Out
                        </a>

                        <form id="profile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">

            <li class="header">MAIN NAVIGATION</li>
            
            @if (Request::is('admin*'))
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="header">INVENTORY</li>

                <li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.index') }}">
                        <i class="material-icons">apps</i>
                        <span>Product Category</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/supplier*') ? 'active' : '' }}">
                    <a href="{{ route('admin.supplier.index') }}">
                        <i class="material-icons">people_alt</i>
                        <span>Product Suppliers</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/purchase*') ? 'active' : '' }}">
                    <a href="{{ route('admin.purchase.index') }}">
                        <i class="material-icons">shopping_bag</i>
                        <span>Purchase</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/product*') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.index') }}">
                        <i class="material-icons">production_quantity_limits</i>
                        <span>Stock</span>
                    </a>
                </li>

                <li class="header">POS</li>

                <li class="{{ Request::is('admin/customer*') ? 'active' : '' }}">
                    <a href="{{ route('admin.customer.index') }}">
                        <i class="material-icons">supervisor_account</i>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/invoice*') ? 'active' : '' }}">
                    <a href="{{ route('admin.invoice.index') }}">
                        <i class="material-icons">important_devices</i>
                        <span>Invoice</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/return*') ? 'active' : '' }}">
                    <a href="{{ route('admin.return.index') }}">
                        <i class="material-icons">replay</i>
                        <span>Return Products</span>
                    </a>
                </li>

                <li class="header">BANKING</li>

                <li class="{{ Request::is('admin/bank*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bank.index') }}">
                        <i class="material-icons">account_balance</i>
                        <span>Bank List</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/branch*') ? 'active' : '' }}">
                    <a href="{{ route('admin.branch.index') }}">
                        <i class="material-icons">room</i>
                        <span>Bank Branches</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/account*') ? 'active' : '' }}">
                    <a href="{{ route('admin.account.index') }}">
                        <i class="material-icons">map</i>
                        <span>Bank Accounts</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/loan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.loan.index') }}">
                        <i class="material-icons">try</i>
                        <span>Loan Accounts</span>
                    </a>
                </li>

                <li class="header">PAYMENT</li>

                <li class="{{ Request::is('admin/creditor*') ? 'active' : '' }}">
                    <a href="{{ route('admin.creditor.index') }}">
                        <i class="material-icons">attach_money</i>
                        <span>Creditors</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/debtor*') ? 'active' : '' }}">
                    <a href="{{ route('admin.debtor.index') }}">
                        <i class="material-icons">local_parking</i>
                        <span>Pendings</span>
                    </a>
                </li>

                <li class="header">EXPENSES</li>

                <li class="{{ Request::is('admin/expense*') ? 'active' : '' }}">
                    <a href="{{ route('admin.expense.create') }}">
                        <i class="material-icons">local_atm</i>
                        <span>Office Expense</span>
                    </a>
                </li>

                <li class="header">PROPRIETOR</li>

                <li class="{{ Request::is('admin/proprietor*') ? 'active' : '' }}">
                    <a href="{{ route('admin.proprietor.index') }}">
                        <i class="material-icons">people</i>
                        <span>Proprietors</span>
                    </a>
                </li>

                <li class="header">EMPLOYEE</li>

                <li class="{{ Request::is('admin/employee*') ? 'active' : '' }}">
                    <a href="{{ route('admin.employee.index') }}">
                        <i class="material-icons">groups</i>
                        <span>Employees</span>
                    </a>
                </li>

                <li class="header">REPORT</li>

                <li class="{{ Request::is('admin/report*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">insert_chart_outlined</i>
                        <span>Reports</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/report/cash') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.cash') }}">Daily Cash</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/sold') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.sold') }}">Sold Products</a>
                        </li>
                        <li class="{{ Request::is('admin/report/return') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.return') }}">Returned Products</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/purchase') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.purchase') }}">Purchased Products</a>
                        </li>  
                        <li class="{{ Request::is('admin/report/sales') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.sales') }}">Sales & Profit</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/purchases') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.purchases') }}">Purchase & Cost</a>
                        </li>  
                        <li class="{{ Request::is('admin/report/sales-details') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.salesDetails') }}">Sales Details</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/purchase-details') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.purchaseDetails') }}">Purchase Details</a>
                        </li>
                        <li class="{{ Request::is('admin/report/proprietor') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.proprietorExpenses') }}">Proprietor Expenses</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/office') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.officeExpenses') }}">Office Expenses</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/bank') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.bankTransactions') }}">Bank Transactions</a>
                        </li> 
                        <li class="{{ Request::is('admin/report/salary') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.employeeSalary') }}">Employee Salary</a>
                        </li>                                     
                    </ul>
                </li>

                <li class="header">SYSTEM</li>

                <li class="{{ Request::is('admin/user*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.index') }}">
                        <i class="material-icons">support_agent</i>
                        <span>Users</span>
                    </a>
                </li>

                {{-- <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="material-icons">settings</i>
                        <span>Settings</span>
                    </a>
                </li> --}}
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Sign Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endif
            
            @if (Request::is('user*'))
                <li class="{{ Request::is('user/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="header">INVENTORY</li>

                <li class="{{ Request::is('user/category*') ? 'active' : '' }}">
                    <a href="{{ route('user.category.index') }}">
                        <i class="material-icons">apps</i>
                        <span>Product Category</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/supplier*') ? 'active' : '' }}">
                    <a href="{{ route('user.supplier.index') }}">
                        <i class="material-icons">people_alt</i>
                        <span>Product Suppliers</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/purchase*') ? 'active' : '' }}">
                    <a href="{{ route('user.purchase.index') }}">
                        <i class="material-icons">shopping_bag</i>
                        <span>Purchase</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/product*') ? 'active' : '' }}">
                    <a href="{{ route('user.product.index') }}">
                        <i class="material-icons">production_quantity_limits</i>
                        <span>Stock</span>
                    </a>
                </li>

                <li class="header">POS</li>

                <li class="{{ Request::is('user/customer*') ? 'active' : '' }}">
                    <a href="{{ route('user.customer.index') }}">
                        <i class="material-icons">supervisor_account</i>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/invoice*') ? 'active' : '' }}">
                    <a href="{{ route('user.invoice.index') }}">
                        <i class="material-icons">important_devices</i>
                        <span>Invoice</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/return*') ? 'active' : '' }}">
                    <a href="{{ route('user.return.index') }}">
                        <i class="material-icons">replay</i>
                        <span>Return Products</span>
                    </a>
                </li>

                <li class="header">PAYMENT</li>

                <li class="{{ Request::is('user/creditor*') ? 'active' : '' }}">
                    <a href="{{ route('user.creditor.index') }}">
                        <i class="material-icons">attach_money</i>
                        <span>Creditors</span>
                    </a>
                </li>
                <li class="{{ Request::is('user/debtor*') ? 'active' : '' }}">
                    <a href="{{ route('user.debtor.index') }}">
                        <i class="material-icons">local_parking</i>
                        <span>Pendings</span>
                    </a>
                </li>

                <li class="header">EXPENSES</li>

                <li class="{{ Request::is('user/expense*') ? 'active' : '' }}">
                    <a href="{{ route('user.expense.create') }}">
                        <i class="material-icons">local_atm</i>
                        <span>Office Expense</span>
                    </a>
                </li>

                <li class="header">System</li>

                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Sign Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endif
        
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; {{ now()->year }}. All rights reserved. <a href="javascript:void(0);">Global Surgical</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.0
        </div>
    </div>
    <!-- #Footer -->
</aside>