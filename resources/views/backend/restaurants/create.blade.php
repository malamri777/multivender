@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Restaurant Information')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'name'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="cr_no">{{translate('CR Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('CR Number')}}" id="cr_no" name="cr_no" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'cr_no'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="vat_no">{{translate('VAT Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('VAT Number')}}" id="vat_no" name="vat_no" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'vat_no'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="logo">{{translate('Gallery Images')}} <small>(600x600)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" class="selected-files">
                                @include('backend.inc.form-span-error', ['field' => 'logo'])
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="text-muted">{{translate('Logo of the restaurant. Use 600x600 sizes images.')}}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{translate('Email')}}</label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'email'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'phone'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="contact_user">{{translate('Contact Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Contact Name')}}" id="contact_user" name="contact_user" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'contact_user'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-md-8">
                            <textarea class="aiz-text-editor" name="description"></textarea>
                            @include('backend.inc.form-span-error', ['field' => 'description'])
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Content')}}</label>
                        <div class="col-md-8">
                            <textarea class="aiz-text-editor" name="content"></textarea>
                            @include('backend.inc.form-span-error', ['field' => 'content'])
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
