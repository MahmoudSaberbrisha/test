@extends('admin.layouts.master')
@section('page_title', __("Expenses Types Settings"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('Expenses Types Settings')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Expenses Types Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add" class="btn btn-success mg-b-20">{{__('Add Expenses Type')}} <i class="typcn typcn-plus"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
										<th class="border-bottom-0">{{__('Name')}}</th>
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

		@include('admin.pages.settings.expenses-types.modals.create')
		@include('admin.pages.settings.expenses-types.modals.edit')

	</div>
	<!-- Container closed -->
</div>
@endsection

@push('js')
	<script type="text/javascript">
		$(function() {
            $('#example1').DataTable({
                ajax: {
			        dataType: "JSON",
			        type: "GET",
			        url: '{{ route(auth()->getDefaultDriver().'.expenses-types.index') }}',
			        data: [],
			        async: true,
			        error: function (xhr, error, code) {
			            console.log(xhr, code);
			        }
			    },
                columns: [
                	{ data: 'id', name: 'id', visible: false },
                    { data: 'name', name: 'name' },
                    { data: 'active', name: 'active', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });
        });
	</script>
@endpush
