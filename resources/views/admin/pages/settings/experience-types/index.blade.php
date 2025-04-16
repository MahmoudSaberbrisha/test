@extends('admin.layouts.master')
@section('page_title', __("Experience Types Settings"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('Experience Types Settings')]])
@endsection

@push('css')
	<link href="{{asset('assets/admin')}}/plugins/spectrum-colorpicker/spectrum.css" rel="stylesheet">
	<style type="text/css">
		.sp-container {
		    background-color: #fff;
		    border-color: #d0d7e8;
		    z-index: 99999 !important;
		}
		.sp-replacer.sp-light {
			width: 100%;
			height: 40px;
			border-radius: 3px;
		}
		.sp-preview {
			width: 92%;
			height: 30px;
		}
		.sp-dd {
			margin-top: 6px;
		}
	</style>
@endpush

@include('admin.partials.datatable-plugins')

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Experience Types Table')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add" class="btn btn-success mg-b-20">{{__('Add Experience Type')}} <i class="typcn typcn-plus"></i></a>
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

		@include('admin.pages.settings.experience-types.modals.create')
		@include('admin.pages.settings.experience-types.modals.edit')

	</div>
	<!-- Container closed -->
</div>
@endsection

@push('js')
	<script src="{{asset('assets/admin')}}/plugins/spectrum-colorpicker/spectrum.js"></script>
	<script type="text/javascript">
		$('.colorpicker').spectrum({
			showButtons: false,
			preferredFormat: "hex",
		});
	</script>

	<script type="text/javascript">
		$(function() {
            $('#example1').DataTable({
                ajax: {
			        dataType: "JSON",
			        type: "GET",
			        url: '{{ route(auth()->getDefaultDriver().'.experience-types.index') }}',
			        data: [],
			        async: true,
			        error: function (xhr, error, code) {
			            console.log(xhr, code);
			        }
			    },
                columns: [
                	{ data: 'id', name: 'id', visible: false },
                    { data: 'colored_name', name: 'colored_name' },
                    { data: 'active', name: 'active', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });
        });
	</script>
@endpush
