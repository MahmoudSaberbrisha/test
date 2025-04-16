@extends('admin.layouts.master')
@section('page_title', __("Employees"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Employee Management'), __('Employees')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Employees Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="{{route(auth()->getDefaultDriver().'.employees.create')}}" class="btn btn-success mg-b-20">{{__('Add Employee')}} <i class="typcn typcn-plus"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
										<th class="border-bottom-0">{{__('Name')}}</th>
										<th class="border-bottom-0">{{__('Branch')}}</th>
										<th class="border-bottom-0">{{__('Job')}}</th>
										<th class="border-bottom-0">{{__('Commission Rate')}}</th>
										<th class="border-bottom-0">{{__('Phone')}}</th>
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
                ajax: '{{ route(auth()->getDefaultDriver().'.employees.index') }}',
                columns: [
                	{ data: 'id', name: 'id', visible: false },
                    { data: 'name', name: 'name' },
					{ data: 'branch', name: 'branch.name' },
            		{ data: 'job', name: 'job.name' },
            		{ 
				        data: 'commission_rate', 
				        name: 'commission_rate',
				        render: function(data, type, row) {
				            return data??0 + ' %';
				        }
				    },
                    { data: 'phone', name: 'phone' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });
        });
	</script>
@endpush