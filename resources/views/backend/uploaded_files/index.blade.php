@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All uploaded files')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
            @if(Request::get('folder_id'))
                @php
                    $folder_id = (int) Request::get('folder_id');
                    $folder = \App\Models\Upload::with('parent')->find($folder_id);
                @endphp
                <a href="{{ route('admin.uploaded-files.index', ['folder_id' => $folder->parent?->id]) }}" class="btn btn-link text-reset">
                    <i class="las la-angle-left"></i>
                    <span>{{translate('Back to uploaded files')}}</span>
                </a>
                <a href="{{ route('admin.uploaded-files.create', ['folder_id' => $folder->id]) }}" class="btn btn-primary">
                    <span>{{translate('Upload New File')}}</span>
                </a>
            @else
                <a href="{{ route('admin.uploaded-files.create') }}" class="btn btn-primary">
                    <span>{{translate('Upload New File')}}</span>
                </a>
            @endif

            <a id="folder-btn" class="btn btn-primary text-white">
                <span>{{translate('New Folder')}}</span>
            </a>
		</div>
	</div>
</div>

<div class="card">
    <form id="sort_uploads" action="">
        <div class="card-header row gutters-5">
            <div class="col-md-3">
                <h5 class="mb-0 h6">{{translate('All files')}}</h5>
            </div>
            <div class="col-md-3 ml-auto mr-0">
                <select class="form-control form-control-xs aiz-selectpicker" name="sort" onchange="sort_uploads()">
                    <option value="newest" @if($sort_by == 'newest') selected="" @endif>{{ translate('Sort by newest') }}</option>
                    <option value="oldest" @if($sort_by == 'oldest') selected="" @endif>{{ translate('Sort by oldest') }}</option>
                    <option value="smallest" @if($sort_by == 'smallest') selected="" @endif>{{ translate('Sort by smallest') }}</option>
                    <option value="largest" @if($sort_by == 'largest') selected="" @endif>{{ translate('Sort by largest') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-xs" name="search" placeholder="{{ translate('Search your files') }}" value="{{ $search }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">{{ translate('Search') }}</button>
            </div>
        </div>
    </form>
    <div class="card-body">
    	<div class="row gutters-5">
            @if($all_uploads->count() > 0)
    		    @foreach($all_uploads as $key => $file)
    			@php
                    if($file->file_original_name == null){
                        $file_name = translate('Unknown');
                    } else {
                        $file_name = $file->file_original_name;
                    }

                    $file_path = my_asset($file->file_name);
                    if($file->external_link) {
                        $file_path = $file->external_link;
                    }

    			@endphp
    			<div class="col-auto w-140px w-lg-220px">
                    @if($file->type === 'folder')
                        {{-- Folder --}}
                        <div class="aiz-file-box">
                            <div class="dropdown-file" >
                                <a class="dropdown-link" data-toggle="dropdown">
                                    <i class="la la-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item confirm-alert" data-href="{{ route('admin.uploaded-files.destroy', $file->id ) }}" data-target="#delete-modal">
                                        <i class="las la-trash mr-2"></i>
                                        <span>{{ translate('Delete') }}</span>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('admin.uploaded-files.index', ['folder_id' => $file->id]) }}">
                                <div class="card card-file aiz-uploader-select c-default" title="{{ $file->folder_name }}">
                                    <div class="card-file-thumb">
                                        <img src="{{ asset('assets/img/folder.svg') }}" class="w-110px">
                                    </div>
                                    <div class="card-body">
                                        <h6 class="d-flex">
                                            <span class="text-truncate title" style="color: black">{{ $file->folder_name }}</span>
                                        </h6>
                                        <p>{{ translate('File Count:') . " " . $file->children->count() }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        {{-- Other Files --}}
                        <div class="aiz-file-box">
                            <div class="dropdown-file" >
                                <a class="dropdown-link" data-toggle="dropdown">
                                    <i class="la la-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item" onclick="detailsInfo(this)" data-id="{{ $file->id }}">
                                        <i class="las la-info-circle mr-2"></i>
                                        <span>{{ translate('Details Info') }}</span>
                                    </a>
                                    <a href="{{ my_asset($file->file_name) }}" target="_blank" download="{{ $file_name }}.{{ $file->extension }}" class="dropdown-item">
                                        <i class="la la-download mr-2"></i>
                                        <span>{{ translate('Download') }}</span>
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-item" onclick="copyUrl(this)" data-url="{{ my_asset($file->file_name) }}">
                                        <i class="las la-clipboard mr-2"></i>
                                        <span>{{ translate('Copy Link') }}</span>
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-item confirm-alert" data-href="{{ route('admin.uploaded-files.destroy', $file->id ) }}" data-target="#delete-modal">
                                        <i class="las la-trash mr-2"></i>
                                        <span>{{ translate('Delete') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="card card-file aiz-uploader-select c-default" title="{{ $file_name }}.{{ $file->extension }}">
                                <div class="card-file-thumb">
                                    @if($file->type == 'folder')
                                        <img src="{{ asset('assets/img/folder.svg') }}" class="w-110px">
                                    @elseif($file->type == 'image')
                                        <img src="{{ $file_path }}" class="img-fit">
                                    @elseif($file->type == 'video')
                                        <i class="las la-file-video"></i>
                                    @else
                                        <i class="las la-file"></i>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h6 class="d-flex">
                                        <span class="text-truncate title">{{ $file_name }}</span>
                                        <span class="ext">.{{ $file->extension }}</span>
                                    </h6>
                                    <p>{{ formatBytes($file->file_size) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
    			</div>
    		@endforeach
            @else
                <div class="align-items-center d-flex h-100 justify-content-center w-100 mt-4">
                    <div class="text-center">
                        <h3>{{ translate('No files found') }}</h3>
                    </div>
                </div>
            @endif
    	</div>
		<div class="aiz-pagination mt-3">
			{{ $all_uploads->appends(request()->input())->links() }}
		</div>
    </div>
</div>
@endsection
@section('modal')
<div id="folder-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ translate('New Folder') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <input type="text" class="form-control mb-4" name="folder-name" id="folder-name" placeholder="{{ translate('Enter folder name') }}">
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <a href="" class="btn btn-primary mt-2 create-folder-el">{{ translate('Create') }}</a>
            </div>
        </div>
    </div>
</div>
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{ translate('Are you sure to delete this file?') }}</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <a href="" class="btn btn-primary mt-2 comfirm-link">{{ translate('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
<div id="info-modal" class="modal fade">
	<div class="modal-dialog modal-dialog-right">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title h6">{{ translate('File Info') }}</h5>
				<button type="button" class="close" data-dismiss="modal">
				</button>
			</div>
			<div class="modal-body c-scrollbar-light position-relative" id="info-modal-content">
				<div class="c-preloader text-center absolute-center">
                    <i class="las la-spinner la-spin la-3x opacity-70"></i>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('script')
	<script type="text/javascript">
		function detailsInfo(e){
            $('#info-modal-content').html('<div class="c-preloader text-center absolute-center"><i class="las la-spinner la-spin la-3x opacity-70"></i></div>');
			var id = $(e).data('id')
			$('#info-modal').modal('show');
			$.post('{{ route('admin.uploaded-files.info') }}', {_token: AIZ.data.csrf, id:id}, function(data){
                $('#info-modal-content').html(data);
				// console.log(data);
			});
		}
		function copyUrl(e) {
			var url = $(e).data('url');
			var $temp = $("<input>");
		    $("body").append($temp);
		    $temp.val(url).select();
		    try {
			    document.execCommand("copy");
			    AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
			} catch (err) {
			    AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
			}
		    $temp.remove();
		}
        function sort_uploads(el){
            $('#sort_uploads').submit();
        }

        $('#folder-btn').click(() => {
            jQuery('#folder-modal').modal('show', {backdrop: 'static'});
        });

        $('.create-folder-el').click(() => {
            let folderNameVal = $("#folder-name").val();
            $.post('{{ route('admin.uploaded-files.createFolder', ['folder_id' => Request::get('folder_id') ?? ""]) }}', {_token: AIZ.data.csrf, name:folderNameVal}, function(data){
                console.log(data);
                AIZ.plugins.notify('success', '{{ translate('Folder Created') }}');
            });

        });
	</script>
@endsection
