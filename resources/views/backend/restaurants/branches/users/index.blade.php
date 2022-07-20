@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Branch  Users') }}</h1>
            </div>
            @permission('restaurants-create')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.restaurants.branches.users.create') }}" class="btn btn-circle btn-info">
                        <span>{{ translate('Add New Branch User') }}</span>
                    </a>
                </div>
            @endpermission
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_sellers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Branch Users') }}</h5>
                </div>

                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ translate('Bulk Action') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"
                            onclick="bulk_delete()">{{ translate('Delete selection') }}</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true" id="sort_branch"
                        name="sort_branch">
                        <option value="">{{ translate('Select Branch User') }}</option>
                        @foreach (\App\Models\Branch::where('status', 1)->get() as $branch)
                            <option value="{{ $branch->id }}" @if ($sort_branch == $branch->id) selected @endif
                                {{ $sort_branch}}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type name or email & Enter') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">{{ translate('Filter') }}</button>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th>
                        <th>{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Phone') }}</th>
                        <th data-breakpoints="lg">{{ translate('Email Address') }}</th>
                        <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
                        <th width="10%">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersBranch as $key => $user)
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]"
                                                value="{{ $user->id }}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone ??1}}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->products?->count() ?? 0}}</td>

                            <td>
                                <div class="dropdown">
                                    <button type="button"
                                        class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                        data-toggle="dropdown" href="javascript:void(0);" role="button"
                                        aria-haspopup="false" aria-expanded="false">
                                        <i class="las la-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                        <a href="#" onclick="show_seller_profile('{{ $user->id }}');"
                                            class="dropdown-item">
                                            {{ translate('Profile') }}
                                        </a>
                                        <a href="{{ route('admin.sellers.login', encrypt($user->id)) }}"
                                            class="dropdown-item">
                                            {{ translate('Log in as this Seller') }}
                                        </a>
                                        <a href="#" onclick="show_seller_payment_modal('{{ $user->id }}');"
                                            class="dropdown-item">
                                            {{ translate('Go to Payment') }}
                                        </a>
                                        <a href="{{ route('admin.sellers.payment_history', encrypt($user->id)) }}"
                                            class="dropdown-item">
                                            {{ translate('Payment History') }}
                                        </a>
                                        @permission('restaurants-update')
                                        <a href="{{ route('admin.restaurants.branches.users.edit', ['user' => $user->id]) }}"
                                            class="dropdown-item">
                                            {{ translate('Edit') }}
                                        </a>
                                        @endpermission
                                        @if ($user->banned != 1)
                                            <a href="#"
                                                onclick="confirm_ban('{{ route('admin.sellers.ban', $user->id) }}');"
                                                class="dropdown-item">
                                                {{ translate('Ban this seller') }}
                                                <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="#"
                                                onclick="confirm_unban('{{ route('admin.sellers.ban', $user->id) }}');"
                                                class="dropdown-item">
                                                {{ translate('Unban this seller') }}
                                                <i class="fa fa-check text-success" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        @permission('restaurants-delete')
                                        <a href="#" class="dropdown-item confirm-delete"
                                            data-href="{{ route('admin.restaurants.users.destroy', $user->id) }}" class="">
                                            {{ translate('Delete') }}
                                        </a>
                                        @endpermission
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $usersBranch->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <!-- Seller Profile Modal -->
    <div class="modal fade" id="profile_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="profile-modal-content">

            </div>
        </div>
    </div>

    <!-- Seller Payment Modal -->
    <div class="modal fade" id="payment_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="payment-modal-content">

            </div>
        </div>
    </div>

    <!-- Ban Seller Modal -->
    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to ban this seller?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a class="btn btn-primary" id="confirmation">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Unban Seller Modal -->
    <div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to unban this seller?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a class="btn btn-primary" id="confirmationunban">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function show_seller_payment_modal(id) {
            $.post('{{ route('admin.sellers.payment_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {
                    backdrop: 'static'
                });
                $('.demo-select2-placeholder').select2();
            });
        }

        function show_seller_profile(id) {
            $.post('{{ route('admin.sellers.profile_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }

        function update_approved(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin.sellers.approved') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Approved sellers updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_sellers(el) {
            $('#sort_sellers').submit();
        }

        function confirm_ban(url) {
            $('#confirm-ban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmation').setAttribute('href', url);
        }

        function confirm_unban(url) {
            $('#confirm-unban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmationunban').setAttribute('href', url);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.bulk-seller-delete') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
