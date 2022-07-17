@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('User Warehouse Information')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.suppliers.warehouses.users.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Supplier') }}</label>
                        <div class="col-sm-9">
                            <select name="supplier_id" id="supplier_id" required class="form-control aiz-selectpicker"
                                data-selected="{{ old('supplier_id') }}">
                                <option value=""></option>
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'supplier_id'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="warehouses">{{ translate('Warehouse') }}</label>
                        <div class="col-sm-9">
                            <select class="select2 form-control aiz-selectpicker" name="warehouses[]" id="warehouses"
                                data-toggle="select2" data-placeholder="Choose ..." data-live-search="true" multiple>
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'warehouses'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="user_type">{{translate('Role')}}</label>
                        <div class="col-sm-9">
                            <select name="user_type" required class="form-control aiz-selectpicker" data-selected="{{ old('user_type', '') }}">
                                <option value=""></option>
                                <option value="warehouse_admin">{{ _('Warehouse Admin') }}</option>
                                <option value="supplier_warehouse_admin">{{ _('Supplier Warehouse Admin') }}</option>
                                <option value="supplier_warehouse_user">{{ _('Supplier Warehouse User') }}</option>
                                <option value="supplier_warehouse_driver">{{ _('Supplier Warehouse Driver') }}</option>
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

@section('script')
    <script type="text/javascript">
        let supplierSelector = $('#supplier_id');
        supplierSelector.change(e => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('admin.suppliers.warehouses.get-warehouse-option-by-supplier-id') }}',
                data: {
                    supplier_id: supplierSelector.val()
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    let warehousesSelector = $('#warehouses');
                    warehousesSelector.empty();
                    warehousesSelector.append(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });
        });
    </script>
@endsection
