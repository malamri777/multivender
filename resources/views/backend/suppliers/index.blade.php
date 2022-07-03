@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All Supplier')}}</h1>
            </div>
            @if(Auth::user()->user_type == 'super_admin')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-circle btn-info">
                        <span>{{translate('Add New Supplier')}}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Suppliers')}}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg" width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('logo')}}</th>
                    <th data-breakpoints="lg">{{translate('admin')}}</th>
                    <th data-breakpoints="lg">{{translate('status')}}</th>
                    <th data-breakpoints="sm" class="text-right">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($suppliers as $key => $supplier)
                    <tr>
                        <td>{{ ($key+1) + ($suppliers->currentPage() - 1)*$suppliers->perPage() }}</td>
                        <td>{{$supplier->name}}</td>
                        <td><img src="{{ uploaded_asset($supplier->logo) }}" class="img-fluid mb-2" style="height: 50px"></td>
                        <td>{{$supplier->admin?->name ?? _('No Admin')}}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_status(this)" value="{{ $supplier->id }}" type="checkbox" <?php if ($supplier->status == 1) echo "checked"; ?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-right">
                                                            {{-- Malak --}}
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.suppliers.warehouses.index', ['sort_supplier'=>$supplier->id])}}" title="{{ translate('warehouse') }}">
                                <i class="las la-warehouse"></i>
                            </a>
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.suppliers.edit', encrypt($supplier->id))}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            @if(Auth::user()->user_type == 'super_admin')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.suppliers.destroy', $supplier->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $suppliers->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection



@section('script')
    <script type="text/javascript">

        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.suppliers.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
