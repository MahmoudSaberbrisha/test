@extends('admin.layouts.master')
@section('page_title', __("Clients"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Clients Management'), __('Clients')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
@endpush

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Clients Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add" class="btn btn-success mg-b-20">{{__('Add Client')}} <i class="typcn typcn-plus"></i></a>
							<a href="javascript:void(0);" data-toggle="modal" data-target="#excel" class="btn btn-dark mg-b-20">{{__('Upload Excel')}} <i class="typcn typcn-cloud-storage"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
										<th class="border-bottom-0">{{__('Name')}}</th>
										<th class="border-bottom-0">{{__('Phone')}}</th>
										<th class="border-bottom-0">{{__('Mobile')}}</th>
										<th class="border-bottom-0">{{__('Country')}}</th>
										<th class="border-bottom-0">{{__('City')}}</th>
										<th class="border-bottom-0">{{__('Active')}}</th>
										<th class="border-bottom-0">{{__('Actions')}}</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		@include('admin.pages.clients-management.clients.modals.create')
		@include('admin.pages.clients-management.clients.modals.edit')
		@include('admin.pages.clients-management.clients.modals.excel')
		@include('admin.pages.clients-management.clients.modals.errors')
		
	</div>
	<!-- Container closed -->
</div>
@endsection

@push('js')
	<script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/fileupload.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/file-upload.js"></script>

	<script type="text/javascript">
		$(function() {
            $('#example1').DataTable({
                ajax: {
			        dataType: "JSON",  
			        type: "GET",
			        url: '{{ route(auth()->getDefaultDriver().'.clients.index') }}',
			        data: [],
			        async: true,
			        error: function (xhr, error, code) {
			            console.log(xhr, code);
			        }
			    },
                columns: [
                	{ data: 'id', name: 'id', visible: false },
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'country', name: 'country' },
                    { data: 'city', name: 'city' },
                    { data: 'active', name: 'active', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });
        });
	</script>

	<script>
        @if (session('import_errors'))
            $(document).ready(function () {
                $('#errorModal').modal('show');
            });
        @endif
    </script>
@endpush