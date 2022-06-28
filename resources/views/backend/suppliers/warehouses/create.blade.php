@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Warehouse Information') }}</h5>
                </div>

                <form class="form-horizontal" action="{{ route('admin.suppliers.warehouses.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'name'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="supplier_id">{{ translate('Supplier') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="supplier_id" id="supplier_id"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                    <option value=""></option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'supplier_id'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="state_id">{{ translate('State') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="state_id" id="state_id"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                    <option value=""></option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'state_id'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="city_id">{{ translate('City') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="city_id" id="city_id"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'city_id'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="district_id">{{ translate('District') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="district_id" id="district_id"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'district_id'])
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
        let stateSelector = $('#state_id');
        let districtSelector = $('#district_id');
        stateSelector.change(e => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('admin.cities.get-city-option-by-state-id') }}',
                data: {
                    state_id: stateSelector.val()
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    let citySelector = $('#city_id');
                    citySelector.empty();
                    districtSelector.empty();
                    citySelector.append(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });
        });

        let citySelector = $('#city_id');
        citySelector.change(e => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('admin.districts.get-districts-option-by-city-id') }}',
                data: {
                    city_id: citySelector.val()
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    let districtSelector = $('#district_id');
                    districtSelector.empty();
                    districtSelector.append(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });
        });
    </script>
@endsection
