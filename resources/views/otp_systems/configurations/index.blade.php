@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('unifonic')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.update_credentials') }}" method="POST">
                        <input type="hidden" name="otp_method" value="unifonic">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="OTP_DEBUG_ENABLE">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('OTP Debug Enable')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" @if(config('myenv.OTP_DEBUG_ENABLE') == "on") checked @endif name="OTP_DEBUG_ENABLE">
                                <span class="slider round"></span>
                            </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="UNIFONIC_KEY">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('UNIFONIC KEY')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="UNIFONIC_KEY" value="{{  config('myenv.UNIFONIC_KEY') }}" placeholder="UNIFONIC KEY" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="UNIFONIC_SECRET">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('UNIFONIC SECRET')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="UNIFONIC_SECRET" value="{{  config('myenv.UNIFONIC_SECRET') }}" placeholder="UNIFONIC SECRET" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="DEFAULT_COUNT">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Default Count')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" min="0" class="form-control" name="DEFAULT_COUNT" value="{{  config('myenv.DEFAULT_COUNT') }}" placeholder="Default Count" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="DEFAULT_TIME_AMOUNT">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Default Time Amount (Minutes)')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" min="0" class="form-control" name="DEFAULT_TIME_AMOUNT" value="{{  config('myenv.DEFAULT_TIME_AMOUNT') }}" placeholder="Default Time Amount (Minutes)" required>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
