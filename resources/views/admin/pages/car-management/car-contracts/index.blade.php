@extends('admin.layouts.master')
@section('page_title', __("Car Contracts"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Car Management'), __('Car Contracts')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Car Contracts Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="{{route(auth()->getDefaultDriver().'.car-contracts.create')}}" class="btn btn-success mg-b-20">{{__('Add Contract')}} <i class="typcn typcn-plus"></i></a>
							<table class="table text-md-nowrap" id="example1">
								<thead>
									<tr>
										<th class="border-bottom-0">{{__('ID')}}</th>
										<th class="border-bottom-0">{{__('Car Supplier')}}</th>
                                        <th class="border-bottom-0">{{__('Car Type')}}</th>
										<th class="border-bottom-0">{{__('Branch')}}</th>
										<th class="border-bottom-0">{{__('Currency')}}</th>
										<th class="border-bottom-0">{{__('Start Date')}}</th>
										<th class="border-bottom-0">{{__('End Date')}}</th>
										<th class="border-bottom-0">{{__('Total')}}</th>
										<th class="border-bottom-0">{{__('Paid')}}</th>
										<th class="border-bottom-0">{{__('Remain')}}</th>
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
</div>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            $('#example1').DataTable({
                ajax: {
			        dataType: "JSON",
			        type: "GET",
			        url: '{{ route(auth()->getDefaultDriver().'.car-contracts.index') }}',
			        data: [],
			        async: true,
			        error: function (xhr, error, code) {
			            console.log(xhr, code);
			        }
			    },
                columns: [
                    { data: 'id', name: 'id', visible: false },
                    { data: 'car_supplier.name', name: 'car_supplier.name' },
                    { data: 'car_type', name: 'car_type' },
					{ data: 'branch.name', name: 'branch.name' },
					{ data: 'currency.name', name: 'currency.name' },
                    { data: 'contract_start_date', name: 'contract_start_date' },
					{ data: 'contract_end_date', name: 'contract_end_date' },
					{ data: 'total', name: 'total' },
                    { data: 'paid', name: 'paid' },
					{ data: 'remain', name: 'remain' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush

