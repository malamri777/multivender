@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Supplier Information')}}</h5>
            </div>
            @include('flash::message')

            <form class="form-horizontal" action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="id" value="{{ $supplier->id }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{ $supplier->name }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="cr_no">{{translate('CR Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('CR Number')}}" id="cr_no" name="cr_no" value="{{ $supplier->cr_no }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="vat_no">{{translate('VAT Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('VAT Number')}}" id="vat_no" name="vat_no" value="{{ $supplier->vat_no }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Supplier Logo')}} <small>(250x250)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" value="{{ $supplier->logo }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="text-muted">{{translate('Logo of the supplier. Use 250x250 sizes images.')}}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{translate('Email')}}</label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" value="{{ $supplier->email }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="phone">{{translate('Phone')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" value="{{ $supplier->phone }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="contact_user">{{translate('Contact Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Contact Name')}}" id="contact_user" name="contact_user" value="{{ $supplier->contact_user }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-md-8">
                            <textarea class="aiz-text-editor" name="description">
                                {{ $supplier->description }}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Content')}}</label>
                        <div class="col-md-8">
                            <textarea class="aiz-text-editor" name="content">
                                {{ $supplier->content }}
                            </textarea>
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
