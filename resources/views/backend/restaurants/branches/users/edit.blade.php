@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('User Branch Information') }}</h5>
                </div>

                <form class="form-horizontal"
                    action="{{ route('admin.restaurants.branches.users.update', ['user' => $branchUser->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="id" type="hidden" value="{{ $branchUser->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    value="{{ $branchUser->name }}" class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'name'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="email">{{ translate('Email') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Email') }}" id="email" name="email"
                                    value="{{ $branchUser->email }} "class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="mobile">{{ translate('Phone') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Phone') }}" id="mobile" name="mobile"
                                    value="{{ $branchUser->phone }}" class="form-control" required>
                                @include('backend.inc.form-span-error', ['field' => 'mobile'])
                            </div>
                        </div>
                        @if(Auth::user()->hasRole(['super_admin', 'admin']))
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="password">{{ translate('New Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="{{ translate('New Password') }}" id="password"
                                        name="password" class="form-control">
                                    @include('backend.inc.form-span-error', ['field' => 'password'])
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="password_confirmation">{{ translate('Confirm New Password') }}</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="{{ translate('Confirm New Password') }}"
                                        id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Restaurant') }}</label>
                            <div class="col-sm-9">
                                <select name="restaurant_id" id="restaurant_id" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $branchUser->restaurant_id }}">
                                    <option value=""></option>
                                    @foreach ($restaurants as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'restaurant_id'])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="branches">{{ translate('Branch') }}</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control aiz-selectpicker" name="branches[]" id="branches"
                                    data-toggle="select2" data-placeholder="Choose ..." data-live-search="true" data-selected="{{ $branchIds }}" multiple>
                                    @if($branchUser->restaurant->restaurantBranches ?? null )
                                        @foreach ($branchUser->restaurant->restaurantBranches as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'branches'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="user_type">{{ translate('Role') }}</label>
                            <div class="col-sm-9">
                                <select name="user_type" required class="form-control aiz-selectpicker"
                                    data-selected="{{ $branchUser->user_type }}">
                                    <option value=""></option>
                                    <option value="branch_admin">{{ _('Branch Admin') }}</option>
                                    <option value="restaurant_branch_admin">{{ _('Restaurant Branchse Admin') }}</option>
                                    <option value="restaurant_branch_user">{{ _('Restaurant Branchse User') }}</option>
                                    <option value="restaurant_branch_admin">{{ _('Restaurant Branchse Admin') }}</option>
                                    <option value="restaurant_branch_driver">{{ _('Restaurant Branchse Driver') }}</option>
                                </select>
                                @include('backend.inc.form-span-error', ['field' => 'user_type'])
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
    <script type="text/javascript">
        let restaurantSelector = $('#restaurant_id');
        restaurantSelector.change(e => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('admin.restaurants.branches.get-branch-option-by-restaurant-id') }}',
                data: {
                    restaurant_id: restaurantSelector.val()
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    let branchesSelector = $('#branches');
                    branchesSelector.empty();
                    branchesSelector.append(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });
        });
    </script>
@endsection
