@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Upload New File')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
            @if(Request::get('folder_id'))
                @php
                    $folder_id = (int) Request::get('folder_id');
                    $folder = \App\Models\Upload::with('parent')->find($folder_id);
                @endphp
                <a href="{{ route('admin.uploaded-files.index', ['folder_id' => $folder->parent?->id]) }}" class="btn btn-link text-reset">
                    <i class="las la-angle-left"></i>
                    <span>{{translate('Previous Folder')}}</span>
                </a>
                <a href="{{ route('admin.uploaded-files.index', ['folder_id' => $folder->id]) }}" class="btn btn-link text-reset">
                    <i class="las la-angle-left"></i>
                    <span>{{translate('Back to the Folder')}}</span>
                </a>
            @endif
                <a href="{{ route('admin.uploaded-files.index') }}" class="btn btn-link text-reset">
                    <i class="las la-angle-left"></i>
                    <span>{{translate('Back to main upload page')}}</span>
                </a>
		</div>
	</div>
</div>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Drag & drop your files')}}</h5>
    </div>
    <div class="card-body">
    	<div id="aiz-upload-files" class="h-420px" style="min-height: 65vh">

    	</div>
    </div>
</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			AIZ.plugins.aizUppy();
		});
	</script>
@endsection
