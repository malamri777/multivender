@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate(' Create User Supplier Information')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.suppliers.users.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{ old('name', '') }}" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{translate('Email')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Email')}}" id="email" name="email" value="{{ old('email', '') }}" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="mobile">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Phone')}}" id="mobile" name="mobile" value="{{ old('mobile', '') }}" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'mobile'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{translate('Password')}}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{translate('Password')}}" id="password" name="password" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'password'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password_confirmation">{{translate('Confirm Password')}}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{translate('Password')}}" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Supplier')}}</label>
                        <div class="col-sm-9">
                            <select name="supplier_id" required class="form-control aiz-selectpicker" data-selected="{{ old('supplier_id', null) }}">
                                <option value=""></option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'supplier_id'])
                        </div>
                    </div>
                    {{--                                     data-selected="{{ $supplierUserRolesId }}" multiple>
                                    @foreach ( $supplierRolesList as $item)
                                        <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                                    @endforeach --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="user_type">{{translate('Role')}}</label>
                        <div class="col-sm-9">
                            <select name="user_type" required class="form-control aiz-selectpicker" data-selected="{{ old('user_type', '') }}" multiple>
                                @foreach ( $supplierRolesList as $item)
                                    <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                                @endforeach
                                {{-- <option value=""></option>
                                <option value="supplier_admin">{{ _('Supplier Admin') }}</option>
                                <option value="supplier_warehouse_admin">{{ _('Supplier Warehouse Admin') }}</option>
                                <option value="supplier_warehouse_user">{{ _('Supplier Warehouse User') }}</option>
                                <option value="supplier_warehouse_driver">{{ _('Supplier Warehouse Driver') }}</option> --}}
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'user_type'])
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
