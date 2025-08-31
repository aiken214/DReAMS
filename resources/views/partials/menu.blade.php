<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }} ">
                            <i class="fa-fw nav-icon fas fa-user-cog"></i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt"></i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase"></i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user"></i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_logs_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt"></i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('system_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/unit*") ? "menu-open" : "" }} {{ request()->is("admin/items_list*") ? "menu-open" : "" }} {{ request()->is("admin/signatory*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/unit*") ? "active" : "" }} {{ request()->is("admin/items_list*") ? "active" : "" }} {{ request()->is("admin/signatory*") ? "active" : "" }} ">
                            <i class="fa-fw nav-icon fas fa-cogs"></i>
                            <p>
                                {{ trans('cruds.systemManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('items_list_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.items_list.index") }}" class="nav-link {{ request()->is("admin/items_list") || request()->is("admin/items_list/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list"></i>
                                        <p>
                                            {{ trans('cruds.items_list.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('unit_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.unit.index") }}" class="nav-link {{ request()->is("admin/unit") || request()->is("admin/unit/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-weight-hanging"></i>
                                        <p>
                                            {{ trans('cruds.unit.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('signatory_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.signatory.index") }}" class="nav-link {{ request()->is("admin/signatory") || request()->is("admin/signatory/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-signature"></i>
                                        <p>
                                            {{ trans('cruds.signatory.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('employee_records_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/employees*") ? "menu-open" : "" }} {{ request()->is("admin/position*") ? "menu-open" : "" }} {{ request()->is("admin/station*") ? "menu-open" : "" }}  ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/employees*") ? "active" : "" }} {{ request()->is("admin/position*") ? "active" : "" }} {{ request()->is("admin/station*") ? "active" : "" }} ">
                            <i class="fa-fw nav-icon fas fa-users-cog"></i>
                            <p>
                                {{ trans('cruds.employeeRecordsManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('employee_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.employees.index") }}" class="nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-friends"></i>
                                        <p>
                                            {{ trans('cruds.employee.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('position_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.position.index") }}" class="nav-link {{ request()->is("admin/position") || request()->is("admin/position/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-shield"></i>
                                        <p>
                                            {{ trans('cruds.position.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('station_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.station.index") }}" class="nav-link {{ request()->is("admin/station") || request()->is("admin/station/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-map-marker-alt"></i>
                                        <p>
                                            {{ trans('cruds.station.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                <!-- Fund Management -->
                @if(Auth::user()->hasRole('Admin'))
                    @can('fund_management_access')
                        <li class="nav-item" style="background-color: #505050;">
                            <a class="nav-link ">                                                                
                                <p>
                                    {{ trans('cruds.FundManagement.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                
                @can('user_fund_management_access')
                    <li class="nav-item has-treeview {{ request()->is("user/fund_utilization*") ? "menu-open" : "" }} {{ request()->is("user/fund_utilization_details*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("user/fund_utilization*") ? "active" : "" }} {{ request()->is("user/fund_utilization_details*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))                            
                                <p>
                                    {{ "End User" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.FundManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('fund_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.fund_utilization.index") }}" class="nav-link {{ request()->is("user/fund_utilization") || request()->is("user/fund_utilization/*") ? "active" : "" }} {{ request()->is("user/fund_utilization_details") || request()->is("user/fund_utilization_details/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-money-bill-wave">

                                        </i>
                                        <p>
                                            {{ trans('cruds.fund.fields.utilization') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('budget_fund_management_access')
                    <li class="nav-item has-treeview {{ request()->is("budget/fund_allocation*") ? "menu-open" : "" }} {{ request()->is("budget/fund_obligation*") ? "menu-open" : "" }} {{ request()->is("budget/fund_obligation_details*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("budget/fund_allocation*") ? "active" : "" }} {{ request()->is("budget/fund_obligation*") ? "active" : "" }} {{ request()->is("budget/fund_obligation_details*") ? "active" : "" }} ">                           
                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "Budget" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.FundManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('fund_allocation_access')
                                <li class="nav-item">
                                    <a href="{{ route("budget.fund_allocation.index") }}" class="nav-link {{ request()->is("budget/fund_allocation") || request()->is("budget/fund_allocation/*") ? "active" : "" }} {{ request()->is("budget/fund_allocation_details") || request()->is("budget/fund_allocation_details/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-money-bill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.fund.fields.fund_allocation') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('fund_obligation_access')
                                <li class="nav-item">
                                    <a href="{{ route("budget.fund_obligation.index") }}" class="nav-link {{ request()->is("budget/fund_obligation") || request()->is("budget/fund_obligation/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-money-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.fund_obligation.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                <!-- Procurement Management -->
                @if(Auth::user()->hasRole('Admin'))   
                    @can('procurement_management_access')
                        <li class="nav-item" style="background-color: #505050;">
                            <a class="nav-link ">                             
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                @can('procurement_management_access')
                    <li class="nav-item has-treeview {{ request()->is("user/ppmp*") ? "menu-open" : "" }} {{ request()->is("user/ppmp_item*") ? "menu-open" : "" }} {{ request()->is("user/ppmp_print*") ? "menu-open" : "" }} {{ request()->is("user/purchase_request*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("user/ppmp*") ? "active" : "" }} {{ request()->is("user/ppmp_item*") ? "active" : "" }} {{ request()->is("user/ppmp_print*") ? "active" : "" }} {{ request()->is("user/purchase_request*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "End User" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('ppmp_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.ppmp.index") }}" class="nav-link {{ request()->is("user/ppmp") || request()->is("user/ppmp/*") ? "active" : "" }} {{ request()->is("user/ppmp_item") || request()->is("user/ppmp_item/*") ? "active" : "" }} {{ request()->is("user/ppmp_print") || request()->is("user/ppmp_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ppmp.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_request_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.purchase_request.index") }}" class="nav-link {{ request()->is("user/purchase_request") || request()->is("user/purchase_request/*") ? "active" : "" }} {{ request()->is("user/purchase_request_item") || request()->is("user/purchase_request_item/*") ? "active" : "" }} {{ request()->is("user/purchase_request_print") || request()->is("user/purchase_request_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_request.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('supply_procurement_management_access')
                    <li class="nav-item has-treeview {{ request()->is("supply/ppmp_check*") ? "menu-open" : "" }} {{ request()->is("supply/ppmp_item_check*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/purchase_request_check*") ? "menu-open" : "" }} {{ request()->is("supply/purchase_request_item_check*") ? "menu-open" : "" }} 
                        {{ request()->is("admin/items_list*") ? "menu-open" : "" }} {{ request()->is("bac/supplier*") ? "menu-open" : "" }}
                        {{ request()->is("supply/checked_purchase_request_print*") ? "menu-open" : "" }} {{ request()->is("supply/checked_ppmp_print*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("supply/ppmp_check*") ? "active" : "" }} {{ request()->is("supply/ppmp_item_check*") ? "active" : "" }} 
                            {{ request()->is("supply/purchase_request_check*") ? "active" : "" }} {{ request()->is("supply/purchase_request_item_check*") ? "active" : "" }} 
                            {{ request()->is("admin/items_list*") ? "active" : "" }} {{ request()->is("bac/supplier*") ? "active" : "" }}
                            {{ request()->is("supply/checked_purchase_request_print*") ? "active" : "" }} {{ request()->is("supply/checked_ppmp_print*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))                           
                                <p>
                                    {{ "Supply" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('items_list_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.items_list.index") }}" class="nav-link {{ request()->is("admin/items_list") || request()->is("admin/items_list/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ul">

                                        </i>
                                        <p>
                                            {{ trans('cruds.items_list.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('supplier_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.supplier.index") }}" class="nav-link {{ request()->is("bac/supplier") || request()->is("bac/supplier/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-file-excel">

                                        </i>
                                        <p>
                                            {{ trans('cruds.supplier.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ppmp_check_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.ppmp_check.index") }}" class="nav-link {{ request()->is("supply/ppmp_check") || request()->is("supply/ppmp_check/*") ? "active" : "" }} {{ request()->is("supply/ppmp_item_check") || request()->is("supply/ppmp_item_check/*") ? "active" : "" }} {{ request()->is("supply/checked_ppmp_print") || request()->is("supply/checked_ppmp_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ppmp.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_request_check_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.purchase_request_check.index") }}" class="nav-link {{ request()->is("supply/purchase_request_check") || request()->is("supply/purchase_request_check/*") ? "active" : "" }} {{ request()->is("supply/purchase_request_item_check") || request()->is("supply/purchase_request_item_check/*") ? "active" : "" }} {{ request()->is("supply/checked_purchase_request_print") || request()->is("supply/checked_purchase_request_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_request.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('budget_procurement_management_access')
                    <li class="nav-item has-treeview {{ request()->is("budget/ppmp_verify*") ? "menu-open" : "" }} {{ request()->is("budget/ppmp_item_verify*") ? "menu-open" : "" }} {{ request()->is("budget/purchase_request_verify*") ? "menu-open" : "" }} 
                        {{ request()->is("budget/purchase_request_item_verify*") ? "menu-open" : "" }} {{ request()->is("budget/verified_purchase_request_print*") ? "menu-open" : "" }}
                        {{ request()->is("budget/verified_ppmp_print*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("budget/ppmp_verify*") ? "active" : "" }} {{ request()->is("budget/ppmp_item_verify*") ? "active" : "" }} {{ request()->is("budget/purchase_request_verify*") ? "active" : "" }} 
                            {{ request()->is("budget/purchase_request_item_verify*") ? "active" : "" }} {{ request()->is("budget/verified_purchase_request_print*") ? "active" : "" }}
                            {{ request()->is("budget/verified_ppmp_print*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "Budget" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('ppmp_verify_access')
                                <li class="nav-item">
                                    <a href="{{ route("budget.ppmp_verify.index") }}" class="nav-link {{ request()->is("budget/ppmp_verify") || request()->is("budget/ppmp_verify/*") ? "active" : "" }} {{ request()->is("budget/ppmp_item_verify") || request()->is("budget/ppmp_item_verify/*") ? "active" : "" }} {{ request()->is("budget/verified_ppmp_print") || request()->is("budget/verified_ppmp_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ppmp.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_request_verify_access')
                                <li class="nav-item">
                                    <a href="{{ route("budget.purchase_request_verify.index") }}" class="nav-link {{ request()->is("budget/purchase_request_verify") || request()->is("budget/purchase_request_verify/*") ? "active" : "" }} {{ request()->is("budget/purchase_request_item_verify") || request()->is("budget/purchase_request_item_verify/*") ? "active" : "" }} {{ request()->is("budget/verified_purchase_request_print") || request()->is("budget/verified_purchase_request_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_request.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('sds_procurement_management_access')
                    <li class="nav-item has-treeview {{ request()->is("sds/ppmp_approve*") ? "menu-open" : "" }} {{ request()->is("sds/ppmp_item_approve*") ? "menu-open" : "" }} {{ request()->is("sds/purchase_request_approve*") ? "menu-open" : "" }} {{ request()->is("sds/purchase_request_item_approve*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("sds/ppmp_approve*") ? "active" : "" }} {{ request()->is("sds/ppmp_item_approve*") ? "active" : "" }} {{ request()->is("sds/purchase_request_approve*") ? "active" : "" }} {{ request()->is("sds/purchase_request_item_approve*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "SDS" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('ppmp_approve_access')
                                <li class="nav-item">
                                    <a href="{{ route("sds.ppmp_approve.index") }}" class="nav-link {{ request()->is("sds/ppmp_approve") || request()->is("sds/ppmp_approve/*") ? "active" : "" }} {{ request()->is("sds/ppmp_item_approve") || request()->is("sds/ppmp_item_approve/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ppmp.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_request_approve_access')
                                <li class="nav-item">
                                    <a href="{{ route("sds.purchase_request_approve.index") }}" class="nav-link {{ request()->is("sds/purchase_request_approve") || request()->is("sds/purchase_request_approve/*") ? "active" : "" }} {{ request()->is("sds/purchase_request_item_approve") || request()->is("sds/purchase_request_item_approve/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_request.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('bac_procurement_management_access')
                    <li class="nav-item has-treeview 
                        {{ request()->is("bac/ppmp_final*") ? "menu-open" : "" }} {{ request()->is("bac/ppmp_item_final*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/app*") ? "menu-open" : "" }} {{ request()->is("bac/app_item*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/app_cse*") ? "menu-open" : "" }} {{ request()->is("bac/app_non_cse*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/purchase_request_final*") ? "menu-open" : "" }} {{ request()->is("bac/purchase_request_item_final*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/request_for_quotation*") ? "menu-open" : "" }} {{ request()->is("bac/request_for_quotation_item*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/purchase_order*") ? "menu-open" : "" }} {{ request()->is("bac/purchase_order_item*") ? "menu-open" : "" }} 
                        {{ request()->is("bac/supplier*") ? "menu-open" : "" }} ">

                        <a class="nav-link nav-dropdown-toggle 
                            {{ request()->is("bac/ppmp_final*") ? "active" : "" }} {{ request()->is("bac/ppmp_item_final*") ? "active" : "" }} 
                            {{ request()->is("bac/app*") ? "active" : "" }} {{ request()->is("bac/app_item*") ? "active" : "" }} 
                            {{ request()->is("bac/app_cse*") ? "active" : "" }} {{ request()->is("bac/app_non_cse*") ? "active" : "" }} 
                            {{ request()->is("bac/purchase_request_final*") ? "active" : "" }} {{ request()->is("bac/purchase_request_item_final*") ? "active" : "" }} 
                            {{ request()->is("bac/request_for_quotation*") ? "active" : "" }} {{ request()->is("bac/request_for_quotation_item*") ? "active" : "" }} 
                            {{ request()->is("bac/purchase_order*") ? "active" : "" }} {{ request()->is("bac/purchase_order_item*") ? "active" : "" }} 
                            {{ request()->is("bac/supplier*") ? "active" : "" }}">

                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "BAC" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.ProcurementManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">
                            @can('ppmp_final_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.ppmp_final.index") }}" class="nav-link {{ request()->is("bac/ppmp_final") || request()->is("bac/ppmp_final/*") ? "active" : "" }} {{ request()->is("bac/ppmp_item_final") || request()->is("bac/ppmp_item_final/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ppmp.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('app_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.app.index") }}" class="nav-link {{ request()->is("bac/app") || request()->is("bac/app/*") ? "active" : "" }} {{ request()->is("bac/app_item") || request()->is("bac/app_item/*") ? "active" : "" }} {{ request()->is("bac/app_cse") || request()->is("bac/app_cse/*") ? "active" : "" }} {{ request()->is("bac/app_non_cse") || request()->is("bac/app_non_cse/*") ? "active" : "" }} {{ request()->is("bac/app_print") || request()->is("bac/app_print/*") ? "active" : "" }} {{ request()->is("bac/app_cse_print") || request()->is("bac/app_cse_print/*") ? "active" : "" }} {{ request()->is("bac/app_non_cse_print") || request()->is("bac/app_non_cse_print/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-file-powerpoint">

                                        </i>
                                        <p>
                                            {{ trans('cruds.app.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_request_final_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.purchase_request_final.index") }}" class="nav-link {{ request()->is("bac/purchase_request_final") || request()->is("bac/purchase_request_final/*") ? "active" : "" }} {{ request()->is("bac/purchase_request_item_final") || request()->is("bac/purchase_request_item_final/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_request.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                            
                            @can('request_for_quotation_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.request_for_quotation.index") }}" class="nav-link {{ request()->is("bac/request_for_quotation") || request()->is("bac/request_for_quotation/*") ? "active" : "" }} {{ request()->is("bac/request_for_quotation_item_final") || request()->is("bac/request_for_quotation_item/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-upload">

                                        </i>
                                        <p>
                                            {{ trans('cruds.request_for_quotation.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_order_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.purchase_order.index") }}" class="nav-link {{ request()->is("bac/purchase_order") || request()->is("bac/purchase_order/*") ? "active" : "" }} {{ request()->is("bac/purchase_request_item_final") || request()->is("bac/purchase_order_item/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-contract">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_order.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('supplier_access')
                                <li class="nav-item">
                                    <a href="{{ route("bac.supplier.index") }}" class="nav-link {{ request()->is("bac/supplier") || request()->is("bac/supplier/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon fas fa-file-excel">

                                        </i>
                                        <p>
                                            {{ trans('cruds.supplier.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- Supply Management -->
                @if(Auth::user()->hasRole('Admin'))   
                    @can('supply_management_access')
                        <li class="nav-item" style="background-color: #505050;">
                            <a class="nav-link ">                             
                                <p>
                                    {{ trans('cruds.SupplyManagement.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                @can('user_supply_management_access')
                    <li class="nav-item has-treeview {{ request()->is("user/ppe_received*") ? "menu-open" : "" }} {{ request()->is("user/ppe_received_print*") ? "menu-open" : "" }} 
                        {{ request()->is("user/semi_expendable_hv_received*") ? "menu-open" : "" }} {{ request()->is("user/semi_expendable_hv_received_print*") ? "menu-open" : "" }}
                        {{ request()->is("user/semi_expendable_lv_received*") ? "menu-open" : "" }} {{ request()->is("user/semi_expendable_lv_received_print*") ? "menu-open" : "" }} ">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("user/ppe_received*") ? "active" : "" }} {{ request()->is("user/ppe_received_print*") ? "active" : "" }} 
                            {{ request()->is("user/semi_expendable_hv_received*") ? "active" : "" }} {{ request()->is("user/semi_expendable_hv_received_print*") ? "active" : "" }} 
                            {{ request()->is("user/semi_expendable_lv_received*") ? "active" : "" }} {{ request()->is("user/semi_expendable_lv_received_print*") ? "active" : "" }} ">
                            @if(Auth::user()->hasRole('Admin'))
                                <p>
                                    {{ "End User" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.SupplyManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">                                                                                                                                                        
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.semi_expendable_lv_received.index") }}" class="nav-link {{ request()->is("user/semi_expendable_lv_received") || request()->is("user/semi_expendable_lv_received/*") ? "active" : "" }} {{ request()->is("user/semi_expendable_lv_received_print") || request()->is("user/semi_expendable_lv_received_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'SP' }} {{ '- LV' }} {{ 'Received' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan  
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.semi_expendable_hv_received.index") }}" class="nav-link {{ request()->is("user/semi_expendable_hv_received") || request()->is("user/semi_expendable_hv_received/*") ? "active" : "" }} {{ request()->is("user/semi_expendable_hv_received_print") || request()->is("user/semi_expendable_hv_received_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'SP' }} {{ '- HV' }} {{ 'Received' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                                                      
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("user.ppe_received.index") }}" class="nav-link {{ request()->is("user/ppe_received") || request()->is("user/ppe_received/*") ? "active" : "" }} {{ request()->is("user/ppe_received_print") || request()->is("user/ppe_received_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'PPE' }} {{ 'Received' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan       
                        </ul>
                    </li>
                @endcan
                @can('supply_management_access')
                    <li class="nav-item has-treeview 
                        {{ request()->is("supply/purchase_order_check*") ? "menu-open" : "" }} {{ request()->is("supply/purchase_order_item_check*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/iar*") ? "menu-open" : "" }} {{ request()->is("supply/iar_item*") ? "menu-open" : "" }}    
                        {{ request()->is("supply/asset*") ? "menu-open" : "" }} {{ request()->is("supply/asset_item*") ? "menu-open" : "" }}    
                        {{ request()->is("supply/donation*") ? "menu-open" : "" }} {{ request()->is("supply/donation_item*") ? "menu-open" : "" }}    
                        {{ request()->is("supply/ris*") ? "menu-open" : "" }} {{ request()->is("supply/ris_item*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/rsmi*") ? "menu-open" : "" }} {{ request()->is("supply/rsmi_item*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/ics_lv*") ? "menu-open" : "" }} {{ request()->is("supply/ics_item_lv*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/ics_hv*") ? "menu-open" : "" }} {{ request()->is("supply/ics_item_hv*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/rspi_hv*") ? "menu-open" : "" }} {{ request()->is("supply/rspi_lv*") ? "menu-open" : "" }}
                        {{ request()->is("supply/regspi_hv*") ? "menu-open" : "" }} {{ request()->is("supply/regspi_lv*") ? "menu-open" : "" }}
                        {{ request()->is("supply/par*") ? "menu-open" : "" }} {{ request()->is("supply/par_item*") ? "menu-open" : "" }}
                        {{ request()->is("supply/rppei*") ? "menu-open" : "" }} {{ request()->is("supply/rrppe*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/regppei*") ? "menu-open" : "" }} {{ request()->is("supply/stock*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/property*") ? "menu-open" : "" }} {{ request()->is("supply/property_card*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/semi_expendable_lv*") ? "menu-open" : "" }} {{ request()->is("supply/semi_expendable_card_lv*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/semi_expendable_hv*") ? "menu-open" : "" }} {{ request()->is("supply/semi_expendable_card_hv*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/rrsp_lv*") ? "menu-open" : "" }} {{ request()->is("supply/rrsp_item_lv*") ? "menu-open" : "" }}
                        {{ request()->is("supply/rrsp_hv*") ? "menu-open" : "" }} {{ request()->is("supply/rrsp_item_hv*") ? "menu-open" : "" }}
                        {{ request()->is("supply/semi_expendable_lv_recipient*") ? "menu-open" : "" }} {{ request()->is("supply/semi_expendable_lv_recipient_item*") ? "menu-open" : "" }}
                        {{ request()->is("supply/semi_expendable_hv_recipient*") ? "menu-open" : "" }} {{ request()->is("supply/semi_expendable_hv_recipient_item*") ? "menu-open" : "" }}
                        {{ request()->is("supply/ppe_recipient*") ? "menu-open" : "" }} {{ request()->is("supply/ppe_recipient_item*") ? "menu-open" : "" }}
                        {{ request()->is("supply/nod*") ? "menu-open" : "" }} 
                        
                        {{ request()->is("supply/purchase_order_check_print*") ? "menu-open" : "" }} {{ request()->is("supply/iar_print*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/ris_print*") ? "menu-open" : "" }} {{ request()->is("supply/rsmi_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/ics_lv_print*") ? "menu-open" : "" }} {{ request()->is("supply/ics_hv_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/par_print*") ? "menu-open" : "" }} {{ request()->is("supply/rspi_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/regspi_hv_print*") ? "menu-open" : "" }} {{ request()->is("supply/rppei_print*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/rrppe_print*") ? "menu-open" : "" }} {{ request()->is("supply/regppei_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/stock_card_print*") ? "menu-open" : "" }} {{ request()->is("supply/semi_expendable_card_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/semi_expendable_card_print*") ? "menu-open" : "" }} {{ request()->is("supply/property_card_print*") ? "menu-open" : "" }} 
                        {{ request()->is("supply/semi_expendable_lv_recipient_print*") ? "menu-open" : "" }} {{ request()->is("supply/ppe_recipient_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/semi_expendable_hv_recipient_print*") ? "menu-open" : "" }} {{ request()->is("supply/nod_print*") ? "menu-open" : "" }} ">

                        <a class="nav-link nav-dropdown-toggle 
                            {{ request()->is("supply/purchase_order_check*") ? "active" : "" }} {{ request()->is("supply/purchase_order_item_check*") ? "active" : "" }} 
                            {{ request()->is("supply/iar*") ? "active" : "" }} {{ request()->is("supply/iar_item*") ? "active" : "" }} 
                            {{ request()->is("supply/asset*") ? "active" : "" }} {{ request()->is("supply/asset_item*") ? "active" : "" }} 
                            {{ request()->is("supply/donation*") ? "active" : "" }} {{ request()->is("supply/donation_item*") ? "active" : "" }} 
                            {{ request()->is("supply/ris*") ? "active" : "" }} {{ request()->is("supply/ris_item*") ? "active" : "" }} 
                            {{ request()->is("supply/rsmi*") ? "active" : "" }} {{ request()->is("supply/rsmi_item*") ? "active" : "" }} 
                            {{ request()->is("supply/ics_lv*") ? "active" : "" }} {{ request()->is("supply/ics_item_lv*") ? "active" : "" }} 
                            {{ request()->is("supply/ics_hv*") ? "active" : "" }} {{ request()->is("supply/ics_item_hv*") ? "active" : "" }} 
                            {{ request()->is("supply/rspi_hv*") ? "active" : "" }} {{ request()->is("supply/rspi_lv*") ? "active" : "" }}
                            {{ request()->is("supply/regspi_hv*") ? "active" : "" }} {{ request()->is("supply/regspi_lv*") ? "active" : "" }} 
                            {{ request()->is("supply/par*") ? "active" : "" }} {{ request()->is("supply/par_item*") ? "active" : "" }}
                            {{ request()->is("supply/rppei*") ? "active" : "" }} {{ request()->is("supply/rrppe*") ? "active" : "" }} 
                            {{ request()->is("supply/regppei*") ? "active" : "" }} {{ request()->is("supply/stock*") ? "active" : "" }}
                            {{ request()->is("supply/property*") ? "active" : "" }} {{ request()->is("supply/property_card*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_lv*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_lv*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_hv*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_hv*") ? "active" : "" }}
                            {{ request()->is("supply/rrsp_lv*") ? "active" : "" }} {{ request()->is("supply/rrsp_item_lv*") ? "active" : "" }}
                            {{ request()->is("supply/rrsp_hv*") ? "active" : "" }} {{ request()->is("supply/rrsp_item_hv*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_lv_recipient*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_lv_recipient_item*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_hv_recipient*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_hv_recipient_item*") ? "active" : "" }}
                            {{ request()->is("supply/ppe_recipient*") ? "active" : "" }} {{ request()->is("supply/ppe_recipient_item*") ? "active" : "" }}
                            {{ request()->is("supply/nod*") ? "active" : "" }} 

                            {{ request()->is("supply/purchase_order_check_print*") ? "active" : "" }} {{ request()->is("supply/iar_print*") ? "active" : "" }} 
                            {{ request()->is("supply/ris_print*") ? "active" : "" }} {{ request()->is("supply/rsmi_print*") ? "active" : "" }} 
                            {{ request()->is("supply/ics_lv_print*") ? "active" : "" }} {{ request()->is("supply/ics_hv_print*") ? "active" : "" }}
                            {{ request()->is("supply/par_print*") ? "active" : "" }} {{ request()->is("supply/rspi_print*") ? "active" : "" }}
                            {{ request()->is("supply/regspi_hv_print*") ? "active" : "" }} {{ request()->is("supply/rppei_print*") ? "active" : "" }}
                            {{ request()->is("supply/rrppe_print*") ? "active" : "" }} {{ request()->is("supply/regppei_print*") ? "active" : "" }}
                            {{ request()->is("supply/stock_card_print*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_print*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_card_print*") ? "active" : "" }} {{ request()->is("supply/property_card_print*") ? "active" : "" }} 
                            {{ request()->is("supply/semi_expendable_lv_recipient_print*") ? "active" : "" }} {{ request()->is("supply/ppe_recipient_print*") ? "active" : "" }}
                            {{ request()->is("supply/semi_expendable_hv_recipient_print*") ? "active" : "" }} {{ request()->is("supply/nod_print*") ? "active" : "" }} ">
                             
                            @if(Auth::user()->hasRole('Admin'))                   
                                <p>
                                    {{ "Supply" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.SupplyManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">                            
                            @can('purchase_order_check_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.purchase_order_check.index") }}" class="nav-link {{ request()->is("supply/purchase_order_check") || request()->is("supply/purchase_order_check/*") ? "active" : "" }} {{ request()->is("supply/purchase_order_item_check") || request()->is("supply/purchase_order_item_check/*") ? "active" : "" }} {{ request()->is("supply/purchase_order_check_print") || request()->is("supply/purchase_order_check_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-contract">

                                        </i>
                                        <p>
                                            {{ trans('cruds.purchase_order.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('iar_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.iar.index") }}" class="nav-link {{ request()->is("supply/iar") || request()->is("supply/iar/*") ? "active" : "" }} {{ request()->is("supply/iar_item") || request()->is("supply/iar_item/*") ? "active" : "" }} {{ request()->is("supply/iar_print") || request()->is("supply/iar_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cart-arrow-down">

                                        </i>
                                        <p>
                                            {{ trans('cruds.iar.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan  
                            @can('nod_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.nod.index") }}" class="nav-link {{ request()->is("supply/nod") || request()->is("supply/nod/*") ? "active" : "" }} {{ request()->is("supply/nod_print") || request()->is("supply/nod_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-luggage-cart">

                                        </i>
                                        <p>
                                            {{ trans('cruds.nod.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                               
                            @can('asset_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.asset.index") }}" class="nav-link {{ request()->is("supply/asset") || request()->is("supply/asset/*") ? "active" : "" }} {{ request()->is("supply/asset_item") || request()->is("supply/asset_item/*") ? "active" : "" }} {{ request()->is("supply/asset_print") || request()->is("supply/asset_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-shopping-cart"></i>
                                        <p>
                                            {{ trans('cruds.asset.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                            
                            @can('donation_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.donation.index") }}" class="nav-link {{ request()->is("supply/donation") || request()->is("supply/donation/*") ? "active" : "" }} {{ request()->is("supply/donation_item") || request()->is("supply/donation_item/*") ? "active" : "" }} {{ request()->is("supply/donation_print") || request()->is("supply/donation_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cart-plus"></i>
                                        <p>
                                            {{ trans('cruds.donation.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ris_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.ris.index") }}" class="nav-link {{ request()->is("supply/ris") || request()->is("supply/ris/*") ? "active" : "" }} {{ request()->is("supply/ris_item") || request()->is("supply/ris_item/*") ? "active" : "" }} {{ request()->is("supply/ris_print") || request()->is("supply/ris_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-folder-symlink-fill ml-1"></i> 
                                        <p>
                                            {{ trans('cruds.ris.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('rsmi_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rsmi.index") }}" class="nav-link {{ request()->is("supply/rsmi") || request()->is("supply/rsmi/*") ? "active" : "" }} {{ request()->is("supply/rsmi_item") || request()->is("supply/rsmi_item/*") ? "active" : "" }} {{ request()->is("supply/rsmi_print") || request()->is("supply/rsmi_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-checklist ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rsmi.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ics_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.ics_lv.index") }}" class="nav-link {{ request()->is("supply/ics_lv") || request()->is("supply/ics_lv/*") ? "active" : "" }} {{ request()->is("supply/ics_item_lv") || request()->is("supply/ics_item_lv/*") ? "active" : "" }} {{ request()->is("supply/ics_lv_print") || request()->is("supply/ics_lv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-folder-check ml-1"></i>
                                        <p>
                                            {{ trans('cruds.ics.title_short') }} - {{ 'LV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ics_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.ics_hv.index") }}" class="nav-link {{ request()->is("supply/ics_hv") || request()->is("supply/ics_hv/*") ? "active" : "" }} {{ request()->is("supply/ics_item_hv") || request()->is("supply/ics_item_hv/*") ? "active" : "" }} {{ request()->is("supply/ics_hv_print") || request()->is("supply/ics_hv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-folder-check ml-1"></i>
                                        <p>
                                            {{ trans('cruds.ics.title_short') }} - {{ 'HV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                      
                            @can('rspi_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rspi_lv.index") }}" class="nav-link {{ request()->is("supply/rspi_lv") || request()->is("supply/rspi_lv/*") ? "active" : "" }} {{ request()->is("supply/rspi_lv_print") || request()->is("supply/rspi_lv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journal-text ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rspi.title_short') }} - {{ 'LV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                              
                            @can('rspi_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rspi_hv.index") }}" class="nav-link {{ request()->is("supply/rspi_hv") || request()->is("supply/rspi_hv/*") ? "active" : "" }} {{ request()->is("supply/rspi_hv_print") || request()->is("supply/rspi_hv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journal-text ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rspi.title_short') }} - {{ 'HV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                          
                            @can('regspi_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.regspi_lv.index") }}" class="nav-link {{ request()->is("supply/regspi_lv") || request()->is("supply/regspi_lv/*") ? "active" : "" }} {{ request()->is("supply/regspi_lv_print") || request()->is("supply/regspi_lv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journals ml-1"></i>
                                        <p>
                                            {{ trans('cruds.regspi.title_short') }} - {{ 'LV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                           
                            @can('regspi_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.regspi_hv.index") }}" class="nav-link {{ request()->is("supply/regspi_hv") || request()->is("supply/regspi_hv/*") ? "active" : "" }} {{ request()->is("supply/regspi_hv_print") || request()->is("supply/regspi_hv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journals ml-1"></i>
                                        <p>
                                            {{ trans('cruds.regspi.title_short') }} - {{ 'HV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                   
                            @can('rrsp_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rrsp_lv.index") }}" class="nav-link {{ request()->is("supply/rrsp_lv") || request()->is("supply/rrsp_lv/*") ? "active" : "" }} {{ request()->is("supply/rrsp_item_lv") || request()->is("supply/rrsp_item_lv/*") ? "active" : "" }} {{ request()->is("supply/rrsp_lv_print") || request()->is("supply/rrsp_lv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journal-x ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rrsp.title_short') }} - {{ 'LV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                   
                            @can('rrsp_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rrsp_hv.index") }}" class="nav-link {{ request()->is("supply/rrsp_hv") || request()->is("supply/rrsp_hv/*") ? "active" : "" }} {{ request()->is("supply/rrsp_item_hv") || request()->is("supply/rrsp_item_hv/*") ? "active" : "" }} {{ request()->is("supply/rrsp_hv_print") || request()->is("supply/rrsp_hv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journal-x ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rrsp.title_short') }} - {{ 'HV'}}
                                        </p>
                                    </a>
                                </li>
                            @endcan             
                            @can('par_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.par.index") }}" class="nav-link {{ request()->is("supply/par") || request()->is("supply/par/*") ? "active" : "" }} {{ request()->is("supply/par_item") || request()->is("supply/par_item/*") ? "active" : "" }} {{ request()->is("supply/par_print") || request()->is("supply/par_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-folder-plus ml-1"></i>
                                        <p>
                                            {{ trans('cruds.par.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                              
                            @can('rppei_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rppei.index") }}" class="nav-link {{ request()->is("supply/rppei") || request()->is("supply/rppei/*") ? "active" : "" }} {{ request()->is("supply/rppei_print") || request()->is("supply/rppei_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-list ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rppei.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                               
                            @can('regppei_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.regppei.index") }}" class="nav-link {{ request()->is("supply/regppei") || request()->is("supply/regppei/*") ? "active" : "" }} {{ request()->is("supply/regppei_print") || request()->is("supply/regppei_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journals ml-1"></i>
                                        <p>
                                            {{ trans('cruds.regppei.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                     
                            @can('rrppe_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rrppe.index") }}" class="nav-link {{ request()->is("supply/rrppe") || request()->is("supply/rrppe/*") ? "active" : "" }} {{ request()->is("supply/rrppe_item") || request()->is("supply/rrppe_item/*") ? "active" : "" }} {{ request()->is("supply/rrppe_print") || request()->is("supply/rrppe_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-journal-x ml-1"></i>
                                        <p>
                                            {{ trans('cruds.rrppe.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                 
                            @can('stock_card_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.stock.index") }}" class="nav-link {{ request()->is("supply/stock") || request()->is("supply/stock/*") ? "active" : "" }} {{ request()->is("supply/stock_card") || request()->is("supply/stock_card/*") ? "active" : "" }} {{ request()->is("supply/stock_card_print") || request()->is("supply/stock_card_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-heading ml-1"></i>
                                        <p>
                                            {{ trans('cruds.stock_card.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                     
                            @can('semi_expendable_card_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.semi_expendable_lv.index") }}" class="nav-link {{ request()->is("supply/semi_expendable_lv") || request()->is("supply/semi_expendable_lv/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_lv") || request()->is("supply/semi_expendable_card_lv/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_lv_print") || request()->is("supply/semi_expendable_card_lv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-heading ml-1"></i>
                                        <p>
                                            {{ trans('cruds.semi_expendable_card.title_short') }} {{ 'LV' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                   
                            @can('semi_expendable_card_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.semi_expendable_hv.index") }}" class="nav-link {{ request()->is("supply/semi_expendable_hv") || request()->is("supply/semi_expendable_hv/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_hv") || request()->is("supply/semi_expendable_card_hv/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_card_hv_print") || request()->is("supply/semi_expendable_card_hv_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-heading ml-1"></i>
                                        <p>
                                            {{ trans('cruds.semi_expendable_card.title_short') }} {{ 'HV' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                          
                            @can('property_card_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.property.index") }}" class="nav-link {{ request()->is("supply/property") || request()->is("supply/property/*") ? "active" : "" }} {{ request()->is("supply/property_card") || request()->is("supply/property_card/*") ? "active" : "" }} {{ request()->is("supply/stock_card_print") || request()->is("supply/property_card_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-card-heading ml-1"></i>
                                        <p>
                                            {{ trans('cruds.property_card.title_singular') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                            
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.semi_expendable_lv_recipient.index") }}" class="nav-link {{ request()->is("supply/semi_expendable_lv_recipient") || request()->is("supply/semi_expendable_lv_recipient/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_lv_recipient_item") || request()->is("supply/semi_expendable_lv_recipient_item/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_lv_recipient_print") || request()->is("supply/semi_expendable_lv_recipient_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'SP' }} {{ '- LV' }} {{ 'Recipient' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                                 
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.semi_expendable_hv_recipient.index") }}" class="nav-link {{ request()->is("supply/semi_expendable_hv_recipient") || request()->is("supply/semi_expendable_hv_recipient/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_hv_recipient_item") || request()->is("supply/semi_expendable_hv_recipient_item/*") ? "active" : "" }} {{ request()->is("supply/semi_expendable_hv_recipient_print") || request()->is("supply/semi_expendable_hv_recipient_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'SP' }} {{ '- HV' }} {{ 'Recipient' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan                                                                                                                                                       
                            @can('recipient_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.ppe_recipient.index") }}" class="nav-link {{ request()->is("supply/ppe_recipient") || request()->is("supply/ppe_recipient/*") ? "active" : "" }} {{ request()->is("supply/ppe_recipient_item") || request()->is("supply/ppe_recipient_item/*") ? "active" : "" }} {{ request()->is("supply/ppe_recipient_print") || request()->is("supply/ppe_recipient_print/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-person-lines-fill ml-1"></i>
                                        <p>
                                            {{ 'PPE' }} {{ 'Recipient' }} 
                                        </p>
                                    </a>
                                </li>
                            @endcan               
                        </ul>
                    </li>
                @endcan

                <!-- Inventory Management -->
                @if(Auth::user()->hasRole('Admin'))   
                    @can('inventory_management_access')
                        <li class="nav-item" style="background-color: #505050;">
                            <a class="nav-link ">                             
                                <p>
                                    {{ trans('cruds.InventoryManagement.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                @can('inventory_management_access')
                    <li class="nav-item has-treeview                         
                        {{ request()->is("supply/rpci*") ? "menu-open" : "" }} {{ request()->is("supply/rpcsp*") ? "menu-open" : "" }}  
                        {{ request()->is("supply/rpcppe*") ? "menu-open" : "" }} {{ request()->is("supply/iirup*") ? "menu-open" : "" }}  
                        {{ request()->is("supply/iirup_item*") ? "menu-open" : "" }} {{ request()->is("supply/iirusp*") ? "menu-open" : "" }}  
                        {{ request()->is("supply/iirusp_item*") ? "menu-open" : "" }}  
                        {{ request()->is("supply/rpci_print*") ? "menu-open" : "" }} {{ request()->is("supply/rpcsp_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/rpcppe_print*") ? "menu-open" : "" }} {{ request()->is("supply/iirup_print*") ? "menu-open" : "" }}
                        {{ request()->is("supply/iirusp_print*") ? "menu-open" : "" }} ">

                        <a class="nav-link nav-dropdown-toggle                             
                            {{ request()->is("supply/rpci*") ? "active" : "" }} {{ request()->is("supply/rpcsp*") ? "active" : "" }}
                            {{ request()->is("supply/rpcppe*") ? "active" : "" }} {{ request()->is("supply/iirup*") ? "active" : "" }}
                            {{ request()->is("supply/iirup_item*") ? "active" : "" }} {{ request()->is("supply/iirusp*") ? "active" : "" }}
                            {{ request()->is("supply/iirusp_item*") ? "active" : "" }}
                            {{ request()->is("supply/rpci_print*") ? "active" : "" }} {{ request()->is("supply/rpcsp_print*") ? "active" : "" }} 
                            {{ request()->is("supply/rpcppe_print*") ? "active" : "" }} {{ request()->is("supply/iirup_print*") ? "active" : "" }} 
                            {{ request()->is("supply/iirusp_print*") ? "active" : "" }}  ">
                             
                            @if(Auth::user()->hasRole('Admin'))
                                <i class="fa-fw nav-icon fas fa-user-friends"></i>                            
                                <p>
                                    {{ "Supply" }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @else
                                <p>
                                    {{ trans('cruds.InventoryManagement.title') }}
                                    <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                </p>
                            @endif
                        </a>
                        <ul class="nav nav-treeview" style="margin-left: 20px">                      
                            @can('rpci_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rpci.index") }}" class="nav-link {{ request()->is("supply/rpci") || request()->is("supply/rpci/*") ? "active" : "" }} {{ request()->is("supply/rpci_print*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-text-fill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.rpci.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('rpcsp_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rpcsp.index") }}" class="nav-link {{ request()->is("supply/rpcsp") || request()->is("supply/rpcsp/*") ? "active" : "" }} {{ request()->is("supply/rpcsp_print*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-text-fill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.rpcsp.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('rpcppe_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.rpcppe.index") }}" class="nav-link {{ request()->is("supply/rpcppe") || request()->is("supply/rpcppe/*") ? "active" : "" }} {{ request()->is("supply/rpcppe_print*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-text-fill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.rpcppe.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('iirusp_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.iirusp.index") }}" class="nav-link {{ request()->is("supply/iirusp") || request()->is("supply/iirusp/*") ? "active" : "" }} {{ request()->is("supply/iirusp_item") || request()->is("supply/iirusp_item/*") ? "active" : "" }} {{ request()->is("supply/iirusp_print*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.iirusp.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('iirup_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.iirup.index") }}" class="nav-link {{ request()->is("supply/iirup") || request()->is("supply/iirup/*") ? "active" : "" }} {{ request()->is("supply/iirup_item") || request()->is("supply/iirup_item/*") ? "active" : "" }} {{ request()->is("supply/iirup_print*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ trans('cruds.iirup.title_short') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            
                            @can('purchase_request_check_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.purchase_request.migration") }}" class="nav-link {{ request()->is("supply/purchase_request") || request()->is("supply/purchase_request/*") ? "active" : "" }} {{ request()->is("supply/purchase_request_item") || request()->is("supply/purchase_request_item/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ 'Migration-PR' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('purchase_order_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.purchase_order.migration") }}" class="nav-link {{ request()->is("supply/purchase_order") || request()->is("supply/purchase_order/*") ? "active" : "" }} {{ request()->is("supply/purchase_order_item") || request()->is("supply/purchase_order_item/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ 'Migration-PO' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('iar_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.iar.migration") }}" class="nav-link {{ request()->is("supply/iar") || request()->is("supply/iar/*") ? "active" : "" }} {{ request()->is("supply/iar_item") || request()->is("supply/iar_item/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ 'Migration-IAR' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('iar_access')
                                <li class="nav-item">
                                    <a href="{{ route("supply.migration.dashboard") }}" class="nav-link {{ request()->is("supply/migration_dashboard") || request()->is("supply/migration_dashboard/*") ? "active" : "" }} ">
                                        <i class="fa-fw nav-icon bi bi-file-earmark-x-fill">

                                        </i>
                                        <p>
                                            {{ 'Migration-Dashboard' }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan





                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>