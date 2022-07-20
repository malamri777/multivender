@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All Braches')}}</h1>
            </div>
            @permission('restaurants-create')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.restaurants.branches.create') }}" class="btn btn-circle btn-info">
                        <span>{{translate('Add New Branches')}}</span>
                    </a>
                </div>
            @endpermission
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_districts" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Branches') }}</h5>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="search_restaurant" name="search_restaurant" @isset($search_restaurant) value="{{ $search_restaurant }}" @endisset placeholder="{{ translate('Type Restaurant name') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_restaurant" name="sort_restaurant">
                        <option value="">{{ translate('Select Restaurant') }}</option>
                        @foreach (\App\Models\Restaurant::where('status', 1)->get() as $restaurants)
                            <option value="{{ $restaurants->id }}" @if ($sort_restaurant == $restaurants->id) selected @endif {{$sort_restaurant}}>
                                {{ $restaurants->name }}
                            </option>
                        @endforeach
                    </select>
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
                <div class="col-md-2">
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
                                $cities = [];
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
                    <th data-breakpoints="lg" width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Logo')}}</th>
                    <th>{{translate('Restaurant')}}</th>
                    <th data-breakpoints="lg">{{translate('Admin')}}</th>
                    <th data-breakpoints="lg">{{translate('status')}}</th>
                    <th data-breakpoints="sm" class="text-right">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($branches as $key => $branch)
                    <tr>
                        <td>{{ ($key+1) + ($branches->currentPage() - 1)*$branches->perPage() }}</td>
                        <td>{{$branches->name ?? _('No Name')}}</td>
                        <td>
                            @if(isset($branches?->restaurant))
                                <img src="{{ uploaded_asset($branches?->restaurant?->logo) }}" class="img-fluid mb-2" style="height: 50px">
                            @else
                                {{ _("No Logo")}}
                            @endif
                        </td>
                        <td>{{$branch->restaurant->name ?? _('No Name')}}</td>
                        <td>{{ $branch->admin->name ?? _('No Admin') }}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_status(this)" value="{{ $branch->id }}" type="checkbox" <?php if ($branch->status == 1) echo "checked"; ?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-right">
                            @permission('restaurants-update')
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.restaurants.branches.edit', encrypt($branch->id))}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            @endpermission
                            @permission('restaurants-delete')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.restaurants.branches.destroy', $branch->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endpermission
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $branches->appends(request()->input())->links() }}
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
            $.post('{{ route('admin.restaurants.branches.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        // $('#sort_restaurant, #sort_state, #sort_city').change(e => {
        //     $('#sort_districts').submit();
        // });

    </script>
@endsection
