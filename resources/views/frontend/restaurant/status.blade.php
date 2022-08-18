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
                    <div class="jumbotron text-center">
                        <h1 class="display-3">Thank You for registering with us!</h1>
                        <p class="lead mt-4">Your account is under review, you will by notify with the status of your account change.</p>
                        <hr>
                        <p>
                            Having trouble? <a href="#">Contact us</a>
                        </p>
                        <p class="lead">
                            <a class="btn btn-primary btn-sm" href="/" role="button">Continue to homepage</a>
                        </p>
                    </div>
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
