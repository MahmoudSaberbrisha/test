@extends('admin.layouts.master')
@section('page_title', __('Bookings'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Bookings Management'), __('Bookings')]])
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/timepicker/jquery.datetimepicker.min.css">

    <style>
        #ui-datepicker-div {
            z-index: 100000 !important;
        }

        .xdsoft_datetimepicker {
            z-index: 100000 !important;
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
                    <h4 class="card-title mg-b-0">{{ __('Bookings Table') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h5>إجمالي المدفوع: <strong>{{ number_format($totalPaid, 2) }}</strong></h5>
                </div>
                <div class="table-responsive">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add"
                        class="btn btn-success mg-b-20">{{ __('Add Booking') }} <i class="typcn typcn-plus"></i></a>
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">{{ __('ID') }}</th>
                                <th class="border-bottom-0"></th>
                                <th class="border-bottom-0">{{ __('Name') }}</th>
                                <th class="border-bottom-0">{{ __('Booking Type') }}</th>
                                <th class="border-bottom-0">{{ __('Branch') }}</th>
                                <th class="border-bottom-0">{{ __('Sailing Boat') }}</th>
                                <th class="border-bottom-0">{{ __('Date') }}</th>
                                <th class="border-bottom-0">{{ __('Start Time') }}</th>
                                <th class="border-bottom-0">{{ __('End Time') }}</th>
                                <th class="border-bottom-0">{{ __('Total Hours') }}</th>
                                <th class="border-bottom-0">{{ __('Total Members') }}</th>
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
    <!-- Container closed -->
    @include('admin.pages.booking-management.bookings.modals.create')
    @include('admin.pages.booking-management.bookings.modals.edit')

    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin') }}/plugins/timepicker/jquery.datetimepicker.full.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

    <script type="text/javascript">
        var table;
        $(function() {
            table = $('#example1').DataTable({
                ajax: {
                    dataType: "JSON",
                    type: "GET",
                    url: '{{ route(auth()->getDefaultDriver() . '.bookings.index') }}',
                    data: [],
                    async: true,
                    error: function(xhr, error, code) {
                        console.log(xhr, code);
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'expand',
                        name: 'expand',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.type && row.type.name ? row.type.name : '-';
                        }
                    },
                    {
                        data: 'booking_type',
                        name: 'booking_type'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.branch && row.branch.name ? row.branch.name : '-';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.sailing_boat && row.sailing_boat.name ? row.sailing_boat
                                .name : '-';
                        }
                    },
                    {
                        data: 'booking_date',
                        name: 'booking_date'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'total_hours',
                        name: 'total_hours'
                    },
                    {
                        data: 'total_members',
                        name: 'total_members'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $('#example1 tbody').on('click', '.expand-btn', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (!row.data()) {
                    console.error('Error: No data found for this row');
                    return;
                }

                var bookingId = row.data()?.id;
                if (!bookingId) {
                    console.error('Error: Booking ID is missing');
                    return;
                }

                if (row.child.isShown()) {
                    row.child.hide();
                    $(this).html('<i class="fas fa-plus"></i>').removeClass('btn-danger').addClass(
                        'btn-primary');
                    tr.removeClass('shown');
                } else {
                    $.ajax({
                        url: '{{ url(auth()->getDefaultDriver() . '/booking-management/bookings/get-groups') }}/' +
                            bookingId,
                        dataType: "JSON",
                        type: "GET",
                        data: [],
                        async: true,
                        success: function(response) {
                            var groupHtml =
                                '<table class="table table-sm table-bordered mt-2">' +
                                '<thead>\
    		                        	<tr>\
    		                        		<th class="border-bottom-0">{{ __('Client') }}</th>\
    		                        		<th>{{ __('Total Members') }}</th>\
    										<th>{{ __('Price') }}</th>\
    										<th>{{ __('Discounted') }}</th>\
    										<th>{{ __('Total') }}</th>\
    										<th>{{ __('Paid') }}</th>\
    										<th>{{ __('Remain') }}</th>\
    										<th>{{ __('Confirm') }}</th>\
    										<th>{{ __('Actions') }}</th>\
    		                        	</tr>\
    		                        </thead>\
    		                        <tbody>';
                            if (response.length > 0) {
                                response.forEach(function(group) {
                                    groupHtml += '<tr>' +
                                        '<td>' + group.client.name + '</td>' +
                                        '<td>' + group.total_members + '</td>' +
                                        '<td>' + group.currency_symbol + ' ' + group
                                        .price + '</td>' +
                                        '<td>' + group.currency_symbol + ' ' + group
                                        .discounted + '</td>' +
                                        '<td>' + group.currency_symbol + ' ' + group
                                        .total + '</td>' +
                                        '<td>' + group.currency_symbol + ' ' + group
                                        .paid + '</td>' +
                                        '<td>' + group.currency_symbol + ' ' + group
                                        .remain + '</td>' +
                                        '<td>' +
                                        '<label for="active' + group.id +
                                        '" class="switch">' +
                                        '<input type="checkbox" id="active' + group.id +
                                        '" ' + (group.active == 1 ? 'checked' : '') +
                                        ' onchange="changeSwitch(this, \'' + group.id +
                                        '\', \'' +
                                        '{{ route(auth()->getDefaultDriver() . '.booking-group-active') }}' +
                                        '\');">' +
                                        '<span class="slider round"></span>' +
                                        '</label>' +
                                        '</td>' +
                                        '<td>' +
                                        '<a class="remove-from-cart modal-effect" href="javascript:void(0);" ' +
                                        'title="{{ __('Delete') }}" ' +
                                        'data-effect="effect-scale" ' +
                                        'data-url="' +
                                        '{{ route(auth()->getDefaultDriver() . '.booking-groups.destroy', '__ID__') }}'
                                        .replace('__ID__', group.id) + '" ' +
                                        'onclick="$(\'#modal-danger form\').attr(\'method\', \'post\'); $(\'#modal-danger form\').attr(\'action\', \'' +
                                        '{{ route(auth()->getDefaultDriver() . '.booking-groups.destroy', '__ID__') }}'
                                        .replace('__ID__', group.id) + '\');"' +
                                        'data-toggle="modal" data-target="#modal-danger">' +
                                        '<i class="fa fa-trash"></i>' +
                                        '</a>\
    											<a class="btn-edit" ' +
                                        'href="' +
                                        '{{ route(auth()->getDefaultDriver() . '.booking-groups.edit', '__ID__') }}'
                                        .replace('__ID__', group.id) + '" ' +
                                        'data-placement="top" title="{{ __('Edit') }}">' +
                                        '<i class="fa fa-edit"></i>' +
                                        '</a>\
    											<a class="btn-sm-dark" target="_blank"' +
                                        'href="' +
                                        '{{ route(auth()->getDefaultDriver() . '.print-invoice', '__ID__') }}'
                                        .replace('__ID__', group.id) + '" ' +
                                        'data-placement="top" title="{{ __('Print Invoice') }}">' +
                                        '<i class="fa fa-print"></i>' +
                                        '</a>\
    											<a class="btn-sm-info"' +
                                        'href="' +
                                        '{{ route(auth()->getDefaultDriver() . '.booking-group-extra-services', '__ID__') }}'
                                        .replace('__ID__', group.id) + '" ' +
                                        'data-placement="top" title="{{ __('Booking Extra Services') }}">' +
                                        '<i class="fa fa-plus"></i>' +
                                        '</a>' +
                                        '</td>' +
                                        '</tr>';
                                });
                            } else {
                                groupHtml +=
                                    '<tr><td colspan="9" class="text-center">{{ __('There are no groups.') }}</td></tr>';
                            }

                            groupHtml += '</tbody></table>';
                            row.child(groupHtml).show();
                            tr.addClass('shown');
                            $(this).html('<i class="fas fa-minus"></i>').removeClass(
                                'btn-primary').addClass('btn-danger');
                        },
                        error: function(xhr, error, code) {
                            console.log(xhr, code);
                        }
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        function calculateDurationCreate() {
            var startTime = $('input[name="start_time"]').val();
            var endTime = $('input[name="end_time"]').val();

            if (startTime && endTime) {
                var startMinutes = convertTimeToMinutesCreate(startTime);
                var endMinutes = convertTimeToMinutesCreate(endTime);
                var durationMinutes = endMinutes - startMinutes;
                var duration = convertMinutesToTimeCreate(durationMinutes);
                $('#duration').val(duration);
            } else {
                $('#duration').val('');
            }
        }

        function convertTimeToMinutesCreate(time) {
            var parts = time.split(':');
            var hours = parseInt(parts[0]);
            var minutes = parseInt(parts[1]);
            return hours * 60 + minutes;
        }

        function convertMinutesToTimeCreate(minutes) {
            var hours = Math.floor(minutes / 60);
            var mins = minutes % 60;
            return hours + ':' + (mins < 10 ? '0' + mins : mins);
        }

        function initCreateTimePicker() {
            var selectedDate = $('.fc-datepicker').datepicker('getDate') ?? new Date();
            var now = new Date();
            var currentHour = now.getHours();
            var currentMinute = now.getMinutes();
            var step = 5;

            if (selectedDate.toDateString() === now.toDateString()) {
                currentMinute = Math.ceil(currentMinute / step) * step;
                if (currentMinute >= 60) {
                    currentHour += 1;
                    currentMinute = 0;
                }
                var minTime = currentHour + ':' + currentMinute;
            } else {
                var minTime = '00:00';
            }
            $('.timepicker').datetimepicker({
                format: 'H:i',
                datepicker: false,
                step: step,
                autocomplete: 'off',
                autoclose: true,
                minTime: minTime,
            }).on('change', function(event) {
                let name = $(this).attr('name');
                calculateDurationCreate();
            }).on('keydown', function(e) {
                e.preventDefault();
            }).attr('autocomplete', 'off');
        }
    </script>

    <script type="text/javascript">
        function initCreateDatePicker() {
            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "yy-mm-dd",
                autoclose: true,
                minDate: new Date()
            }).on('change', function() {
                $('.timepicker').val('').datetimepicker('update');
                initCreateTimePicker();
            }).on('keydown', function(e) {
                e.preventDefault();
            }).attr('autocomplete', 'off');
        }
    </script>

    <script type="text/javascript">
        initCreateDatePicker();
        initCreateTimePicker();
    </script>
@endpush
