@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('District Information')}}</h5>
</div>

<div class="row">
  <div class="col-lg-8 mx-auto">
      <div class="card">
          <div class="card-body p-0">
              @include('backend.inc.admin_lang_form_menu', ['route_name' => 'admin.districts.edit', 'params' => ['district'=>$district->id] ])
              <form class="p-4" action="{{ route('admin.districts.update', $district->id) }}" method="POST" enctype="multipart/form-data">
                  <input name="_method" type="hidden" value="PATCH">
                  <input type="hidden" name="lang" value="{{ $lang }}">
                  @csrf

                  <div class="form-group">
                      <label for="state_id">{{translate('State')}}</label>
                      <select class="select2 form-control aiz-selectpicker" name="state_id" data-selected="{{ $district->city->state_id }}" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                          @foreach ($states as $state)
                              <option value="{{ $state->id }}">{{ $state->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group">
                      <label for="state_id">{{translate('City')}}</label>
                      <select class="select2 form-control aiz-selectpicker" name="city_id" data-selected="{{ $district->city_id }}" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                          @foreach ($cities as $city)
                              <option value="{{ $city->id }}">{{ $city->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group mb-3">
                      <label for="name">{{translate('Name')}}</label>
                      <input type="text" placeholder="{{translate('Name')}}" value="{{ $district->getTranslation('name', $lang) }}" name="name" class="form-control" required>
                  </div>


                  <div class="form-group mb-3 text-right">
                      <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

@endsection
