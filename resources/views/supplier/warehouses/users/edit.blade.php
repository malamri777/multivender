@extends('supplier.layouts.app')

@section('panel_content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate(' Edit User Warehouse Information') }}</h5>
                </div>

                <form class="form-horizontal"
                    action="{{ route('supplier.warehouse.user.update', ['user' => $warehouseUser->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{ $warehouseUser->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    value="{{ $warehouseUser->name }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="email">{{ translate('Email') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Email') }}" id="email" name="email"
                                    value="{{ $warehouseUser->email }} "class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="mobile">{{ translate('Phone') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Phone') }}" id="mobile" name="mobile"
                                    value="{{ $warehouseUser->phone }}" class="form-control" required>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole(['super_admin', 'admin']))
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="password">{{ translate('New Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="{{ translate('New Password') }}" id="password"
                                        name="password" class="form-control">
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
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Supplier') }}</label>
                            <div class="col-sm-9">
                                <select name="supplier_id" id="supplier_id" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $suppliers }}">
                                    @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="warehouses">{{ translate('Warehouse') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="warehouses[]" id="warehouses"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true" data-selected="{{ $warehouseIds }}" multiple>
                                    @if($warehouseUser->supplier->supplierWarehouses ?? null )
                                        @foreach ($warehouseUser->supplier->supplierWarehouses as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="user_type">{{ translate('Role') }}</label>
                            <div class="col-sm-9">
                                <select name="user_type" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $warehouseUserRolesId}}" multiple>
                                    @foreach ( $warehouseRolesList as $item)
                                    <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                                 @endforeach
                                    {{-- <option value=""></option>
                                    <option value="warehouse_admin">{{ _('Warehouse Admin') }}</option>
                                    <option value="supplier_warehouse_admin">{{ _('Supplier Warehouse Admin') }}</option>
                                    <option value="supplier_warehouse_user">{{ _('Supplier Warehouse User') }}</option>
                                    <option value="supplier_warehouse_driver">{{ _('Supplier Warehouse Driver') }}</option> --}}
                                </select>
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
