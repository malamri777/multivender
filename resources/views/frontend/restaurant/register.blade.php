@extends('frontend.layouts.app')

@section('style')
<style>
    .sm-height {
        height: 43px !important;
    }

    /* ------------ message ------------ */
    body {
        margin-top: 20px;
    }

    .mail-seccess {
        text-align: center;
        background: #fff;
        border-top: 1px solid #eee;
    }

    .mail-seccess .success-inner {
        display: inline-block;
    }

    .mail-seccess .success-inner h1 {
        font-size: 100px;
        text-shadow: 3px 5px 2px #3333;
        color: #006DFE;
        font-weight: 700;
    }

    .mail-seccess .success-inner h1 span {
        display: block;
        font-size: 25px;
        color: #333;
        font-weight: 600;
        text-shadow: none;
        margin-top: 20px;
    }

    .mail-seccess .success-inner p {
        padding: 20px 15px;
    }

    .mail-seccess .success-inner .btn {
        color: #fff;
    }
</style>
@endsection
@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ translate('Home') }}</a>
            <span></span> {{ translate('Restaurant')}} <span></span> {{translate('Register') }}
        </div>
    </div>
</div>
<div class="page-content pb-150">
    <section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 mt-100">
                    <form role="form" class="login-box" action="{{ route('restaurantRegisterForm') }}" method="POST">
                        @csrf
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active"">
                                <h4 class="text-center mt-5">{{ translate('Create a new Restaurant') }}</h4>
                                @if(session()->has('error'))
                                    <div class="alert alert-info m-4">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input class="form-control sm-height" type="text" name="name" value="{{ old('name') }}" placeholder="" required>
                                            @include('backend.inc.form-span-error', ['field' => 'name'])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vat No</label>
                                            <input class="form-control sm-height" type="text" name="vat_no" value="{{ old('vat_no') }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CR No *</label>
                                            <input class="form-control sm-height" type="text" name="cr_no" value="{{ old('cr_no') }}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CR Expiry Date *</label>
                                            <input class="form-control sm-height" type="text" name="expiryDate" value="{{ old('expiryDate') }}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Name</label>
                                            <input class="form-control sm-height" type="text" name="contact_user" value="{{ old('contact_user') }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Email</label>
                                            <input class="form-control sm-height" type="email" name="email" value="{{ old('email') }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Phone Number</label>
                                            <input class="form-control sm-height" type="text" name="phone" value="{{ old('phone') }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4 mysubmit">
                                        <div class="form-group">
                                            <button style="float: right;" type="submit" class="btn btn-primary btn-submit next-step">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script type="text/javascript">



</script>
@endsection
