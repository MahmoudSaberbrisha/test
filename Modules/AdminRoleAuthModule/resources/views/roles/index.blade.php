@extends('admin.layouts.master')
@section('page_title', __("Roles"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Users & Roles'), __('Roles')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Roles Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="{{route(auth()->getDefaultDriver().'.roles.create')}}" id="button" class="btn btn-success mg-b-20">{{__('Add Role')}} <i class="typcn typcn-plus"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
										<th class="border-bottom-0">{{__('Name')}}</th>
										<th class="border-bottom-0">{{__('Guard Name')}}</th>
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
	</div>
	<!-- Container closed -->
</div>
@endsection

@push('js')
	<script type="text/javascript">
		$(function() {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
				responsive: true,
				info: true,
        		paging: true,
        		language: {
			        url: languageUrl,
			    },
                "lengthMenu": [ [10, 25, 50], [10, 25, 50] ],
        		"pageLength": 10,
                ajax: '{{ route(auth()->getDefaultDriver().'.roles.index') }}',
                columns: [
                	{ data: 'id', name: 'id', visible: true },
                    { data: 'name', name: 'name' },
                    { data: 'guard_name', name: 'guard_name' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                dom: '<"row" <"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"Bf>>rtip',
		        buttons: [
		            'copy', 'csv', 'excel', 'pdf', 'print'
		        ],
		        order: [[0, 'desc']],
            });
        });
	</script>
@endpush
