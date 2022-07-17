@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('User Warehouse Information') }}</h5>
                </div>

                <form class="form-horizontal"
                    action="{{ route('admin.suppliers.warehouses.users.update', ['user' => $warehouse->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{ $warehouse->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    value="{{ $warehouse->name }}" class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="email">{{ translate('Email') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Email') }}" id="email" name="email"
                                    value="{{ $warehouse->email }} "class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="mobile">{{ translate('Phone') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Phone') }}" id="mobile" name="mobile"
                                    value="{{ $warehouse->phone }}" class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'mobile'])
                            </div>
                        </div>
                        @if (Auth::user()->user_type == 'super_admin' or Auth::user()->user_type == 'admin')
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="password">{{ translate('New Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="{{ translate('New Password') }}" id="password"
                                        name="password" class="form-control">
                                    @include('backend.inc.form-span-error', ['field' => 'password'])
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="password_confirmation">{{ translate('Confirm New Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="{{ translate('Confirm New Password') }}"
                                        id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Warehouse') }}</label>
                            <div class="col-sm-9">
                                <select name="warehouse_id" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $warehouse->provider_id }}">
                                    <option value=""></option>
                                    @foreach ($warehouses as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'warehouse_id'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="user_type">{{ translate('Role') }}</label>
                            <div class="col-sm-9">
                                <select name="user_type" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $warehouse->user_type }}">
                                    <option value=""></option>
                                    <option value="wrehouse_admin">{{ _('Warehouse Admin') }}</option>
                                    <option value="supplier_warehouse_admin">{{ _('Supplier Warehouse Admin') }}</option>
                                    <option value="supplier_warehouse_user">{{ _('Supplier Warehouse User') }}</option>
                                    <option value="supplier_warehouse_driver">{{ _('Supplier Warehouse Driver') }}
                                    </option>
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'user_type'])
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
