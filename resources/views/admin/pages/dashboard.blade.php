@extends('admin.layouts.master')
@section('page_title', __("Dashboard"))

@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Dashboard'), __('Dashboard & Statistics')]])
@endsection

@push('css')
	<link href="{{asset('assets/admin')}}/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
	<link href="{{ asset('assets/admin/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
	<style>
        .main-calendar td.fc-today .fc-day-number:hover, .main-calendar td.fc-today .fc-day-number {
            background-color : #dde2ef !important;
        }
        .main-calendar td.fc-today .fc-day-number{
            color : #4D5875 !important;
        }
        .main-calendar td.fc-today {
        	background-color: #dde2ef  !important;
        }
        .apexcharts-canvas {
    direction: rtl; /* يجعل الرسم البياني ينعكس */
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
            @can('View Dashboard')
                <div class="row row-sm " style="scroll-behavior: auto">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-primary-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{__("Active Clients")}}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$active_clients}}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i style='font-size:35px' class="fas fa-users text-white"></i>
                                            <span class="text-white op-7"> </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-danger-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{__('Confirmed Bookings')}}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$active_booking_groups}}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i style='font-size:35px' class="fas fa-anchor text-white"></i>
                                            <span class="text-white op-7"> </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{__('Active Sailing Boats')}}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$active_sailing_boats}}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i style='font-size:35px' class="fas fa-life-ring text-white"></i>
                                            <span class="text-white op-7"> </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-warning-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{__('Active Extra Services')}}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$active_extra_services}}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i style='font-size:35px' class="fas fa-concierge-bell text-white"></i>
                                            <span class="text-white op-7"> </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                        </div>
                    </div>
                </div>

                <div class="row row-sm">
                    <div class="col-lg-12 col-xl-12">
                        <div class="main-content-body main-content-body-calendar card p-4">
                            <div class="main-calendar" id="calendar"></div>
                        </div>
                    </div>
                </div>

                <div class="row row-sm">
                    <div class="col-md-12 col-lg-12 col-xl-8">
                        <div class="card">
                            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">{{__('This Year Bookings')}}</h4>
                                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="total-revenue">
                                    @foreach($this_year_booking_groups as $key => $booking)
                                        <div>
                                          <h4>{{$booking->currency->code . ' ' . number_format($booking->total_amount, 2)}}</h4>
                                          <label><span class="bg-primary" style="background-color: {{$booking->currency->color}} !important"></span>{{$booking->currency->name}}</label>
                                        </div>
                                    @endforeach
                                  </div>
                                <div id="bar1" class="sales-bar mt-4"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-12 col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h3 class="card-title mb-2">{{__('Recent Bookings')}}</h3>
                            </div>
                            <div class="card-body sales-info ot-0 pt-0 pb-0">
                                <div id="chart" class="ht-200"></div>
                                <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                                    <div class="col-md-6 col">
                                        <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>{{__('Price')}}</p>
                                        <h3 class="mb-1">{{$lastSixMonth->price}}</h3>
                                        <div class="d-flex">
                                            <p class="text-muted ">{{__('Last 6 months')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col">
                                        <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>{{__('Total')}}</p>
                                            <h3 class="mb-1">{{$lastSixMonth->total}}</h3>
                                        <div class="d-flex">
                                            <p class="text-muted">{{__('Last 6 months')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row row-sm">
                    {{-- <div class="col-md-12 col-lg-12 col-xl-8">
                        <div class="card">
                            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">{{__('Last Year Bookings')}}</h4>
                                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="total-revenue">
                                    @foreach($last_year_booking_groups as $key => $booking)
                                        <div>
                                          <h4>{{$booking->currency->code .' '. number_format($booking->total_amount, 2)}}</h4>
                                          <label><span class="bg-primary" style="background-color: {{$booking->currency->color}} !important"></span>{{$booking->currency->name}}</label>
                                        </div>
                                    @endforeach
                                  </div>
                                <div id="bar2" class="sales-bar mt-4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-4">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center pb-2">
                                            <p class="mb-0">{{__('Total Payments')}}</p>
                                        </div>
                                        <h4 class="font-weight-bold mb-2">{{$activeStudentsPayments}}</h4>
                                        <div class="progress progress-style progress-sm">
                                            <div class="progress-bar bg-primary-gradient wd-{{$paymentRatio}}p" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4 mt-md-0">
                                        <div class="d-flex align-items-center pb-2">
                                            <p class="mb-0">{{__('Active Students')}}</p>
                                        </div>
                                        <h4 class="font-weight-bold mb-2">{{$studentsWithGroup}} - {{$totalStudents}}</h4>
                                        <div class="progress progress-style progress-sm">
                                            <div class="progress-bar bg-danger-gradient wd-{{$studentRatio}}" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            @else
            <div class="row row-sm">
                <div class="col-lg-12 col-xl-12">
                    <div class="main-content-body main-content-body-calendar card p-4">
                        <div class="main-calendar" id="calendar"></div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <div class="modal" id="modal-details" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title" id="groupDetailsModalLabel">{{__("Booking Details")}}</h4>
                </div>
                <livewire:booking-group-details />
                <div class="modal-footer">
                    <button class="btn ripple btn-danger" type="button" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
	<!--Internal  Chart.bundle js -->
	<script src="{{asset('assets/admin')}}/plugins/chart.js/Chart.bundle.min.js"></script>
	<!-- Moment js -->
	<script src="{{asset('assets/admin')}}/plugins/raphael/raphael.min.js"></script>
	<!--Internal  Flot js-->
	<script src="{{asset('assets/admin')}}/plugins/jquery.flot/jquery.flot.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/jquery.flot/jquery.flot.pie.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/jquery.flot/jquery.flot.resize.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/jquery.flot/jquery.flot.categories.js"></script>
	<script src="{{asset('assets/admin')}}/js/dashboard.sampledata.js"></script>
	<script src="{{asset('assets/admin')}}/js/chart.flot.sampledata.js"></script>
	<!--Internal Apexchart js-->
	<script src="{{asset('assets/admin')}}/js/apexcharts.js"></script>
	<script src="{{asset('assets/admin')}}/js/modal-popup.js"></script>
	<!--calendar -->
	<script src="{{ asset('assets/admin/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('assets/admin/plugins/fullcalendar/locale/' . app()->getLocale() . '.js') }}"></script>
	<script src="{{ asset('assets/admin/js/app-calendar-events.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app-calendar.js') }}"></script>
    <!--Internal  index js -->
	<script src="{{asset('assets/admin')}}/js/index.js"></script>

	<script type="text/javascript">
		/* Apexcharts (#bar) */
		var thisYearBookingGroupsBar = {!! $thisYearBookingGroupsBar !!};
		var optionsBar = {
		  	chart: {
				height: 249,
				type: 'bar',
				toolbar: {
				   show: false,
				},
				fontFamily: 'Nunito, sans-serif',
			 },
		 	colors: {!! $bookingGroupsBarColors !!},
		 	plotOptions: {
				bar: {
				  	dataLabels: {
						enabled: false
				  	},
				  	columnWidth: '42%',
				  	endingShape: 'rounded',
				  	horizontal: false,
				}
			},
		  	dataLabels: {
			  	enabled: false
		  	},
		  	stroke: {
			  	show: true,
			  	width: 2,
			  	endingShape: 'rounded',
			  	colors: ['transparent'],
		  	},
		  	responsive: [{
			  	breakpoint: 576,
			  	options: {
				   	stroke: {
					  	show: true,
					  	width: 1,
					  	endingShape: 'rounded',
					  	colors: ['transparent'],
					},
			  	},
		  	}],
		   	series: thisYearBookingGroupsBar,
		  	xaxis: {
			  	categories: ['{{__("Jan")}}', '{{__("Feb")}}', '{{__("Mar")}}', '{{__("Apr")}}', '{{__("May")}}', '{{__("Jun")}}', '{{__("Jul")}}', '{{__("Aug")}}', '{{__("Sep")}}', '{{__("Oct")}}', '{{__("Nov")}}', '{{__("Dec")}}'],
			  	reversed: true,
		  	},
		  	yaxis: {
	        	reversed: false
	    	},
		  	fill: {
			  	opacity: 1
		  	},
		  	legend: {
				show: false,
				floating: true,
				position: 'top',
				horizontalAlign: 'left',
		  	},
		}
		new ApexCharts(document.querySelector('#bar1'), optionsBar).render();
	</script>

	<script type="text/javascript">
		/* Apexcharts (#bar) */
		var thisYearBookingGroupsBar = {!! $thisYearBookingGroupsBar !!};
		var optionsBar = {
		  	chart: {
				height: 249,
				type: 'bar',
				toolbar: {
				   show: false,
				},
				fontFamily: 'Nunito, sans-serif',
			 },
		 	colors: {!! $bookingGroupsBarColors !!},
		 	plotOptions: {
				bar: {
				  	dataLabels: {
						enabled: false
				  	},
				  	columnWidth: '42%',
				  	endingShape: 'rounded',
				  	horizontal: false,
				}
			},
		  	dataLabels: {
			  	enabled: false
		  	},
		  	stroke: {
			  	show: true,
			  	width: 2,
			  	endingShape: 'rounded',
			  	colors: ['transparent'],
		  	},
		  	responsive: [{
			  	breakpoint: 576,
			  	options: {
				   	stroke: {
					  	show: true,
					  	width: 1,
					  	endingShape: 'rounded',
					  	colors: ['transparent'],
					},
			  	},
		  	}],
		   	series: thisYearBookingGroupsBar,
		  	xaxis: {
			  	categories: ['{{__("Jan")}}', '{{__("Feb")}}', '{{__("Mar")}}', '{{__("Apr")}}', '{{__("May")}}', '{{__("Jun")}}', '{{__("Jul")}}', '{{__("Aug")}}', '{{__("Sep")}}', '{{__("Oct")}}', '{{__("Nov")}}', '{{__("Dec")}}'],
			  	reversed: true,
		  	},
		  	yaxis: {
	        	reversed: false
	    	},
		  	fill: {
			  	opacity: 1
		  	},
		  	legend: {
				show: false,
				floating: true,
				position: 'top',
				horizontalAlign: 'left',
		  	},
		}
		new ApexCharts(document.querySelector('#bar2'), optionsBar).render();
	</script>

	<script type="text/javascript">
		/*--- Apex (#chart) ---*/
		var options = {
			chart: {
			height: 205,
			type: 'radialBar',
			offsetX: 0,
	        offsetY: 0,
		},
		plotOptions: {
		  	radialBar: {
				startAngle: -135,
				endAngle: 135,
				size: 120,
			 	imageWidth: 50,
	            imageHeight: 50,
			 	track: {
			 		strokeWidth: "80%",
			 		background: '#ecf0fa',
				},
			 	dropShadow: {
	                enabled: false,
	                top: 0,
	                left: 0,
					bottom: 0,
	                blur: 3,
	                opacity: 0.5
	             },
				dataLabels: {
			  		name: {
						fontSize: '16px',
						color: undefined,
						offsetY: 30,
			  		},
			  		hollow: {
				 		size: "60%"
					},
			  		value: {
						offsetY: -10,
						fontSize: '22px',
						color: undefined,
						formatter: function (val) {
				  			return val + "%";
						}
			  		}
				}
		  	}
		},
		colors: ['#0db2de'],
	  	fill: {
	   		type: "gradient",
	   		gradient: {
	    		shade: "dark",
	    		type: "horizontal",
	    		shadeIntensity: .5,
	    		gradientToColors: ['#005bea'],
	    		inverseColors: !0,
	    		opacityFrom: 1,
	    		opacityTo: 1,
	    		stops: [0, 100]
	   		}
	  	},
		stroke: {
		  	dashArray: 4
		},
	   	series: [{{number_format(($lastSixMonth->total / ($lastSixMonth->price > 0 ? $lastSixMonth->price : 1)) * 100, 2)}}],
			labels: [""]
		};
		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();
	</script>

	<script>
		$(document).ready(function () {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month'
				},
				editable: false,
				droppable: false,
				events: @json($calendarEvents),
				eventRender: function(event, element) {
			        element.find('.fc-title').html(event.title);

			        element.css({
			            "background": "transparent",
			            "border": "none",
			            "text-align": "center",
			        });

			        element.find('.fc-title i').css({
			            "font-size": "24px",
			            "color": event.color,
			        });

			        element.find('.fc-time').css({
			            "display": "none",
			        });
			    },
				dayRender: function (date, cell) {
					if (date.isSame(new Date(), 'day')) {
						cell.css('background-color', '#E5DBDB');
					}
				},
				eventClick: function(event) {
					Livewire.dispatch("openModal", {id:  event.id} );
					/*var bookingGroup = event.bookingGroup;
					$('#client_name').text(bookingGroup.client.name);
					$('#sailing_boat_name').text(bookingGroup.booking.sailing_boat.name);
					$('#booking_type').text(bookingGroup.booking.type.name);
					$('#total_members').text(bookingGroup.booking.total_members);
					$('#start_time').text(bookingGroup.booking.start_time);
					$('#end_time').text(bookingGroup.booking.end_time);
					$('#total_hours').text(bookingGroup.booking.total_hours);
					$('#hour_member_price').text(bookingGroup.currency.symbol+bookingGroup.hour_member_price);
					$('#price').text(bookingGroup.currency.symbol+bookingGroup.price);
					$('#discounted').text(bookingGroup.currency.symbol+bookingGroup.discounted);
					$('#paid').text(bookingGroup.currency.symbol+bookingGroup.paid);
					$('#remain').text(bookingGroup.currency.symbol+bookingGroup.remain);
					$('#detailsModal').modal('show');*/
				}
			});
		});
	</script>
@endpush
