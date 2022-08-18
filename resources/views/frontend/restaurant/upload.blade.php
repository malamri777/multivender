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
            <span></span> {{ translate('Restaurant')}} <span></span> {{translate('Register') }} <span></span> {{translate('Upload File') }}
        </div>
    </div>
</div>
<div class="page-content pb-150">
    <section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 mt-100">
                    <form role="form" class="login-box" action="{{ route('restaurantRegisterForm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active"">
                                <h4 class=" text-center mt-5">{{ $restaurant->name }} - {{ translate('Restaurant')}} - {{ translate('Upload file') }}</h4>
                                @if(session()->has('error'))
                                <div class="alert alert-info m-4">
                                    {{ session('error') }}
                                </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Logo *</label>
                                                    <input class="form-control sm-height upload" data-type="logo" type="file" name="logo" id="logo"
                                                        value="{{ old('logo') }}" placeholder="" required>
                                                    @include('backend.inc.form-span-error', ['field' => 'logo'])
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <img id="logoPreview" src="{{ asset('assets/img/placeholder.jpg') }}" style="height: 100px; @if($restaurant->logo == null) display: none @endif" alt="">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>CR File *</label>
                                                    <input class="form-control sm-height upload" data-type="cr" type="file" name="cr_file" id="cr_file"
                                                        value="{{ old('cr_file') }}" placeholder="" required>
                                                    @include('backend.inc.form-span-error', ['field' => 'cr_file'])
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <img id="crPreview" src="{{ asset('assets/img/placeholder.jpg') }}" style="height: 100px; @if($restaurant->cr_file == null) display: none @endif" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>VAT Image *</label>
                                                    <input class="form-control sm-height upload" data-type="vat" type="file" name="vat_file" id="vat_file"
                                                        value="{{ old('vat_file') }}" placeholder="" required>
                                                    @include('backend.inc.form-span-error', ['field' => 'vat_file'])
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <img id="vatPreview" src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    style="height: 100px; @if($restaurant->vat_file == null) display: none @endif" alt="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mt-4 mysubmit">
                                        <div class="form-group">
                                            <a href="{{ route('restaurantRegisterUploaderStatus', ['restaurant' => $restaurant])}}" style="float: right;" type="submit" class="btn btn-primary btn-submit next-step">Next</a>
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

$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#logo').change(function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0])
        formData.append('kind', 'logo')

        $.ajax({
            type:'POST',
            url: "{{ route('restaurantRegisterUploader', ['restaurant' => $restaurant])}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                var logo = $('#logoPreview');
                logo.css('display', 'block');
                logo.attr('src', data.file_name)
            },
            error: function(data){
                console.log(data);
            }
        });
    });

    $('#cr_file').change(function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0])
        formData.append('kind', 'cr')

        $.ajax({
            type:'POST',
            url: "{{ route('restaurantRegisterUploader', ['restaurant' => $restaurant])}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                var cr = $('#crPreview');
                cr.css('display', 'block');
                cr.attr('src', data.file_name)
            },
            error: function(data){
                console.log(data);
                alert("Error Upload you Image");
            }
        });
    });

    $('#vat_file').change(function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0])
        formData.append('kind', 'vat')

        $.ajax({
            type:'POST',
            url: "{{ route('restaurantRegisterUploader', ['restaurant' => $restaurant])}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                var vat = $('#vatPreview');
                vat.css('display', 'block');
                vat.attr('src', data.file_name)
            },
            error: function(data){
                console.log(data);
                alert("Error Upload you Image");
            }
        });
    });

});

</script>
@endsection
