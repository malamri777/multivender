@extends('backend.layouts.app')

@push('styles')
<style>
    h3 {
        text-align: center;
    }
    .bootstrap-select {
        width: 100% !important;
    }
    .bootstrap-select .dropdown-menu .status {
        display: block;
        padding: 0.5rem 1.5rem;
        margin-bottom: 0;
        font-size: .875rem;
        color: #7d726c !important;
        white-space: nowrap;
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('restaurant Information') }}</h5>
                </div>

                <form class="form-horizontal" action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="id" value="{{ $restaurant->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    value="{{ $restaurant->name }}" class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'name'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="admin_id">{{ translate('Restaurant Admin') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control aiz-selectpicker-ajax with-ajax" data-abs-cache="true"
                                data-live-search="true" id="admin_id" name="admin_id"></select>
                                @include('backend.inc.form-span-error', ['field' => 'admin_id'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="cr_no">{{ translate('CR Number') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('CR Number') }}" id="cr_no"
                                    name="cr_no" value="{{ $restaurant->cr_no }}" class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'cr_no'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="vat_no">{{ translate('VAT Number') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('VAT Number') }}" id="vat_no"
                                    name="vat_no" value="{{ $restaurant->vat_no }}" class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'vat_no'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Restaurant Logo') }}
                                <small>(250x250)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="logo" value="{{ $restaurant->logo }}"
                                        class="selected-files">
                                        @include('backend.inc.form-span-error', ['field' => 'logo'])
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small
                                    class="text-muted">{{ translate('Logo of the restaurant. Use 250x250 sizes images.') }}</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="email">{{ translate('Email') }}</label>
                            <div class="col-sm-9">
                                <input type="email" placeholder="{{ translate('Email') }}" id="email" name="email"
                                    value="{{ $restaurant->email }}" class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="phone">{{ translate('Phone') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Phone') }}" id="phone" name="phone"
                                    value="{{ $restaurant->phone }}" class="form-control" required>
                                    @include('backend.inc.form-span-error', ['field' => 'phone'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label"
                                for="contact_user">{{ translate('Contact Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Contact Name') }}" id="contact_user"
                                    name="contact_user" value="{{ $restaurant->contact_user }}" class="form-control"
                                    required>
                                    @include('backend.inc.form-span-error', ['field' => 'contact_user'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description">
                                {{ $restaurant->description }}
                            </textarea>
                            @include('backend.inc.form-span-error', ['field' => 'description'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Content') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="content">
                                {{ $restaurant->content }}
                            </textarea>
                            @include('backend.inc.form-span-error', ['field' => 'content'])
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.3.8/js/ajax-bootstrap-select.min.js"></script>
    <script type="text/javascript">

var options = {
  values: "a, b, c",
  ajax: {
    url: "{{ route('admin.restaurants.query-users-selector', ['restaurant' => $restaurant->id])}}",
    type: "GET",
    dataType: "json",
    //  as a placeholder and Ajax Bootstrap Select will
    // automatically replace it with the value of the search query.
    data: {
    }
  },
  locale: {
    emptyTitle: " {{ _('Select and Begin Typing') }}",
  },
  log: 3,
  preprocessData: function(data) {
    let results = JSON.parse(data.results).data;
    console.log("data:", results);
    // return [];
    var i,
      l = results.length,
      array = [];
      console.log("L:", l);
    if (l) {
      for (i = 0; i < l; i++) {
        array.push(
          $.extend(true, results[i], {
            text: results[i].name,
            value: results[i].id,
            data: {
              subtext: results[i].id
            }
          })
        );
      }
    }
    // You must always return a valid array when processing data. The
    // data argument passed is a clone and cannot be modified directly.
    return array;
  },
  preserveSelected: true
};

$(".aiz-selectpicker-ajax")
  .selectpicker()
  .filter(".with-ajax")
  .ajaxSelectPicker(options);
$("select").trigger("change");


        // $('input[type=search]').on('keyup', function() {
        //     $.ajax({
        //         type: "POST",
        //         url: 'sim-area.php',
        //         data: {changeStatus: $('#changeStatus').val()},
        //         success: function() {
        //         "area switched"
        //         }
        //     });
        // });
    </script>
@endsection
