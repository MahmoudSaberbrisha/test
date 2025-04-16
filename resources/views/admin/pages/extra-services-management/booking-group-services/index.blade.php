@extends('admin.layouts.master')
@section('page_title', __("Booking Extra Services"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Extra Services Management'), __('Booking Extra Services')]])
@endsection

@include('admin.partials.datatable-plugins')

@section('content')
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">{{ __('Booking Extra Services Table') }}</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="{{ route(auth()->getDefaultDriver() . '.booking-extra-services.create') }}" class="btn btn-success mg-b-20">{{ __('Add Booking Extra Services') }} <i class="typcn typcn-plus"></i></a>
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">{{__('ID')}}</th>
                                        <th class="border-bottom-0"></th>
                                        <th class="border-bottom-0">{{ __('Branch') }}</th>
                                        <th class="border-bottom-0">{{ __('Booking Type') }}</th>
                                        <th class="border-bottom-0">{{ __('Client Name') }}</th>
                                        <th class="border-bottom-0">{{ __('Booking Date Time') }}</th>
                                        <th class="border-bottom-0">{{ __('Sailing Boat') }}</th>
                                        <th class="border-bottom-0">{{ __('Total Services') }}</th>
                                        <th class="border-bottom-0">{{ __('Actions') }}</th>
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
        var table;
        $(function() {
            table = $('#example1').DataTable({
                ajax: {
                    dataType: "JSON",
                    type: "GET",
                    url: '{{ route(auth()->getDefaultDriver() . '.booking-extra-services.index') }}',
                    data: [],
                    async: true,
                    error: function(xhr, error, code) {
                        console.log(xhr, code);
                    }
                },
                columns: [
                    { data: 'booking_group_id', name: 'booking_group_id', visible: false },
                    { data: 'expand', name: 'expand', orderable: false, searchable: false },
                    { data: 'branch', name: 'branch' },
                    { data: 'booking_type', name: 'booking_type' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'booking_date_time', name: 'booking_date_time' },
                    { data: 'sailing_boat', name: 'sailing_boat' },
                    { data: 'total_services', name: 'total_services' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });

            $('#example1 tbody').on('click', '.expand-btn', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (!row.data()) {
                    console.error('Error: No data found for this row');
                    return;
                }

                var bookingGroupId = row.data()?.booking_group_id;
                if (!bookingGroupId) {
                    console.error('Error: Booking ID is missing');
                    return;
                }

                if (row.child.isShown()) {
                    row.child.hide();
                    $(this).html('<i class="fas fa-plus"></i>').removeClass('btn-danger').addClass('btn-primary');
                    tr.removeClass('shown');
                } else {
                    $.ajax({
                        url: '{{ url(auth()->getDefaultDriver().'/extra-services-management/booking-extra-services/get-services') }}/' + bookingGroupId,
                        dataType: "JSON",  
                        type: "GET",
                        data: [],
                        async: true,
                        success: function(response) {
                            var serviceHtml = '<table class="table table-sm table-bordered mt-2">' +
                                '<thead>\
                                    <tr>\
                                        <th class="border-bottom-0">{{__('Extra Service')}}</th>\
                                        <th>{{__('Count')}}</th>\
                                        <th>{{__('Price')}}</th>\
                                        <th>{{__('Total')}}</th>\
                                        <th>{{__('Paid')}}</th>\
                                        <th>{{__('Remain')}}</th>\
                                        <th>{{__('Actions')}}</th>\
                                    </tr>\
                                </thead>\
                                <tbody>';
                            if (response.length > 0) {
                                response.forEach(function(service) {
                                    serviceHtml += '<tr>' +
                                        '<td>' + service.extra_service.name + '</td>' +
                                        '<td>' + service.services_count + '</td>' +
                                        '<td>' +  service.currency_symbol + ' ' + service.price + '</td>' +
                                        '<td>' +  service.currency_symbol + ' ' + service.total + '</td>' +
                                        '<td>' +  service.currency_symbol + ' ' + service.paid + '</td>' +
                                        '<td>' +  service.currency_symbol + ' ' + service.remain + '</td>' +
                                        '<td>' + 
                                            '<a class="remove-from-cart modal-effect" href="javascript:void(0);" ' +
                                                'title="{{ __('Delete') }}" ' +
                                                'data-effect="effect-scale" ' +
                                                'data-url="' + '{{ route(auth()->getDefaultDriver().'.delete-service', '__ID__') }}'.replace('__ID__', service.id) + '" ' +
                                                'onclick="$(\'#modal-danger form\').attr(\'method\', \'post\'); $(\'#modal-danger form\').attr(\'action\', \'' + '{{ route(auth()->getDefaultDriver().'.delete-service', '__ID__') }}'.replace('__ID__', service.id) + '\');"' +
                                                'data-toggle="modal" data-target="#modal-danger">' +
                                                '<i class="fa fa-trash"></i>' +
                                            '</a>\
                                            <a class="btn-sm-dark" target="_blank"' +
                                                'href="' + '{{ route(auth()->getDefaultDriver().'.print-service-invoice', '__ID__') }}'.replace('__ID__', service.id) + '" ' +
                                                'data-placement="top" title="{{ __('Print Invoice') }}">' +
                                                '<i class="fa fa-print"></i>' +
                                            '</a>'
                                         + '</td>' +
                                    '</tr>';
                                });
                            }

                            serviceHtml += '</tbody></table>';
                            row.child(serviceHtml).show();
                            tr.addClass('shown');
                            $(this).html('<i class="fas fa-minus"></i>').removeClass('btn-primary').addClass('btn-danger');
                        },
                        error: function (xhr, error, code) {
                            console.log(xhr, code);
                        }
                    });
                }
            });
        });
    </script>
@endpush