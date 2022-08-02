@extends('supplier.layouts.app')

@section('panel_content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('All Warehouse  Users') }}</h1>
        </div>
        @permission('user-create')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('supplier.warehouse.user.create') }}" class="btn btn-square btn-info">
                    <span>{{ translate('Add New Warehouse User') }}</span>
                </a>
            </div>
        @endpermission
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Warehouse Users') }}</h5>
            </div>

            <div class="dropdown mb-2 mb-md-0">
                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    {{ translate('Bulk Action') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"
                        onclick="bulk_delete()">{{ translate('Delete selection') }}</a>
                </div>
            </div>

            <div class="col-md-3">
                <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_warehouse"
                    name="sort_warehouse">
                    <option value="">{{ translate('Select Warehouse') }}</option>
                    @foreach (\App\Models\Warehouse::where('status', 1)->get() as $warehouse)
                        <option value="{{ $warehouse->id }}" @if ($sort_warehouse == $warehouse->id) selected @endif
                            {{ $sort_warehouse }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search"
                        name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type name or email & Enter') }}">
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" type="submit">{{ translate('Filter') }}</button>
            </div>
        </div>
    </form>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>
                        <div class="form-group">
                            <div class="aiz-checkbox-inline">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" class="check-all">
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                        </div>
                    </th>
                    <th>{{ translate('Name') }}</th>
                    <th data-breakpoints="lg">{{ translate('Phone') }}</th>
                    <th data-breakpoints="lg">{{ translate('Email Address') }}</th>
                    <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
                    <th width="10%">{{ translate('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersWarehouse as $key => $user)
                    <tr>
                        <td>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-one" name="id[]"
                                            value="{{ $user->id }}">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone ??1}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->products?->count() ?? 0}}</td>

                        <td>
                            <div class="dropdown">
                                <button type="button"
                                    class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                    data-toggle="dropdown" href="javascript:void(0);" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                    <i class="las la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    {{-- <a href="#" onclick="show_seller_profile('{{ $user->id }}');"
                                        class="dropdown-item">
                                        {{ translate('Profile') }}
                                    </a>
                                    <a href="{{ route('admin.sellers.login', encrypt($user->id)) }}"
                                        class="dropdown-item">
                                        {{ translate('Log in as this Seller') }}
                                    </a>
                                    <a href="#" onclick="show_seller_payment_modal('{{ $user->id }}');"
                                        class="dropdown-item">
                                        {{ translate('Go to Payment') }}
                                    </a>
                                    <a href="{{ route('admin.sellers.payment_history', encrypt($user->id)) }}"
                                        class="dropdown-item">
                                        {{ translate('Payment History') }}
                                    </a> --}}
                                    @permission('user-update')
                                    <a href="{{ route('supplier.warehouse.user.edit', ['id' => $user->id]) }}"
                                        class="dropdown-item">
                                        {{ translate('Edit') }}
                                    </a>
                                    @endpermission
                                    {{-- @if ($user->banned != 1)
                                        <a href="#"
                                            onclick="confirm_ban('{{ route('admin.sellers.ban', $user->id) }}');"
                                            class="dropdown-item">
                                            {{ translate('Ban this seller') }}
                                            <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a href="#"
                                            onclick="confirm_unban('{{ route('admin.sellers.ban', $user->id) }}');"
                                            class="dropdown-item">
                                            {{ translate('Unban this seller') }}
                                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        </a>
                                    @endif --}}
                                    @permission('user-delete')
                                    <a href="#" class="dropdown-item confirm-delete"
                                        data-href="{{ route('supplier.warehouse.user.destroy',['id' => $user->id]) }}" class="">
                                        {{ translate('Delete') }}
                                    </a>
                                    @endpermission
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $usersWarehouse->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

