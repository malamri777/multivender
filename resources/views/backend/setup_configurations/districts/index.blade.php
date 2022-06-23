@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All Districts')}}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('admin.districts.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Coupon')}}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="form" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Districts') }}</h5>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="search_district" name="search_district" @isset($search_district) value="{{ $search_district }}" @endisset placeholder="{{ translate('Type District name & Enter') }}">
                </div>
                <div class="col-md-4">
                    <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_city" name="sort_city">
                        <option value="">{{ translate('Select State') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if ($sort_city == $city->id) selected @endif {{$sort_city}}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table p-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Country')}}</th>
                    <th data-breakpoints="lg">{{translate('Sates')}}</th>
                    <th data-breakpoints="lg">{{translate('City')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($districts as $key => $district)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$district->name}}</td>
                        <td>{{$district->city->state->country->name}}</td>
                        <td>{{$district->city->state->name}}</td>
                        <td>{{$district->city->name}}</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.districts.edit', ['district' => $district->id] )}}" title="{{ translate('Edit') }}">
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
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_city(el){
            $('#form').submit();
        }

        $('#sort_city').change(e => {
            $('#form').submit();
        })


    </script>
@endsection
