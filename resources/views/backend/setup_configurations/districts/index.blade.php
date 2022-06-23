@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="h3">{{translate('All Districts')}}</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <form class="" id="sort_districts" action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col text-center text-md-left">
                            <h5 class="mb-md-0 h6">{{ translate('Districts') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="search_district" name="search_district" @isset($search_district) value="{{ $search_district }}" @endisset placeholder="{{ translate('Type District name') }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_state" name="sort_state">
                                <option value="">{{ translate('Select State') }}</option>
                                @foreach (\App\Models\State::where('status', 1)->get() as $state)
                                    <option value="{{ $state->id }}" @if ($sort_state == $state->id) selected @endif {{$sort_state}}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_city" name="sort_city">
                                <option value="">{{ translate('Select City') }}</option>
                                @php
                                    if($sort_state) {
                                        $cities = \App\Models\City::where('status', 1)
                                            ->whereHas('state', function ($q) use ($sort_state) {
                                                $q->where('id', $sort_state);
                                            })
                                            ->get();
                                    } else {
                                        $cities = \App\Models\City::where('status', 1)
                                            ->get();
                                    }
                                @endphp
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if ($sort_city == $city->id) selected @endif {{$sort_city}}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
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
                            <th width="10%">#</th>
                            <th>{{translate('Name')}}</th>
                            <th>{{translate('State')}}</th>
                            <th>{{translate('City')}}</th>
                            <th>{{translate('Show/Hide')}}</th>
                            <th class="text-right">{{translate('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($districts as $key => $district)
                            <tr>
                                <td>{{ ($key+1) + ($districts->currentPage() - 1)*$districts->perPage() }}</td>
                                <td>{{ $district->name }}</td>
                                <td>{{ $district->city->state->name ?? '' }}</td>
                                <td>{{ $district->city->name ?? '' }}</td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_status(this)" value="{{ $district->id }}" type="checkbox" <?php if($district->status == 1) echo "checked";?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('admin.districts.edit', $district->id) }}" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.districts.destroy', $district->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $districts->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New State') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.districts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="country_id" value="1">

{{--                        <div class="form-group">--}}
{{--                            <label for="country">{{translate('Country')}}</label>--}}
{{--                            <select class="select2 form-control aiz-selectpicker" name="country_id" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">--}}
{{--                                @foreach (\App\Models\Country::where('status', 1)->get() as $country)--}}
{{--                                    <option value="{{ $country->id }}">--}}
{{--                                        {{ $country->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="country">{{translate('State')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="state_id" id="state-selector" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                @php
                                    $states = \App\Models\State::where('status', 1)->where('country_id', 1)->get();
                                @endphp
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="country">{{translate('City')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="city_id" id="city-selector" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true" required>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.districts.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Country status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        $('#sort_state, #sort_city').change(e => {
            $('#sort_districts').submit();
        });
        let stateSelector = $('#state-selector');
        stateSelector.change(e => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:'{{ route('admin.cities.get-city-option-by-state-id') }}',
                data:{
                    state_id: stateSelector.val()
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    let citySelector = $('#city-selector');
                    citySelector.empty();
                    citySelector.append(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });
        });

    </script>
@endsection
