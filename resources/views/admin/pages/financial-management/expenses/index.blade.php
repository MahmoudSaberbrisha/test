@extends('admin.layouts.master')
@section('page_title', __("Expenses"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Financial Management'), __('Expenceses')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Expenses Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="{{route(auth()->getDefaultDriver().'.expenses.create')}}" class="btn btn-success mg-b-20">{{__('Add Expense')}} <i class="typcn typcn-plus"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
                                        <th class="border-bottom-0">{{__('Branch')}}</th>
										<th class="border-bottom-0">{{__('Name')}}</th>
                                        <th class="border-bottom-0">{{__('Value')}}</th>
                                        <th class="border-bottom-0">{{__('Currency')}}</th>
                                        <th class="border-bottom-0">{{__('Date')}}</th>
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
                ajax: {
			        dataType: "JSON",  
			        type: "GET",
			        url: '{{ route(auth()->getDefaultDriver().'.expenses.index') }}',
			        data: [],
			        async: true,
			        error: function (xhr, error, code) {
			            console.log(xhr, code);
			        }
			    },
                columns: [
                    { data: 'id', name: 'id', visible: false },
                    { data: 'branch.name', name: 'branch.name' },
                    { data: 'expenses_type.name', name: 'expenses_type.name' },
                    { data: 'value', name: 'value' },
                    { data: 'currency.name', name: 'currency.name' },
                    { data: 'expense_date', name: 'expense_date' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush

