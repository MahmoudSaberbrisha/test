@push('css')
	<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
	<style type="text/css">
		.fm-tree>.fm-tree-branch {
		    padding-left: 0 !important;
		    padding-right: 0 !important;
		}
		.list-unstyled li {
		    display: block !important;
		    margin-bottom: 0px !important;
		}
	</style>
@endpush

@extends('admin.layouts.master')
@section('page_title', __("File Manager"))

@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('File Manager')]])
@endsection

@section('content')
		<div class="col-xl-12 col-lg-12 col-md-12 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
					<div id="fm"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ @asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script type="text/javascript">
	$('button[title=About]').remove();
</script>
@endpush
