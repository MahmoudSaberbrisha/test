@push('css')
	<!-- Internal Data table css -->
	<link href="{{asset('assets/admin')}}/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<style type="text/css">
		table.table tbody td {
			vertical-align: middle;
		}
	</style>
@endpush

@push('js')
	<!-- Internal Data tables -->
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/dataTables.bootstrap4.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/dataTables.buttons.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/jszip.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/pdfmake.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/vfs_fonts.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/buttons.html5.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/buttons.print.min.js"></script>
	<script src="{{asset('assets/admin')}}/plugins/datatable/js/buttons.colVis.min.js"></script>
	<script type="text/javascript">
		var languageUrl = '{{asset('assets/admin')}}/plugins/datatable/i18n/{{app()->getLocale()}}.json';
 	</script>
 	<script type="text/javascript">
 		$(document).ready(function () {
		    $.extend(true, $.fn.dataTable.defaults, {
		    	processing: true,
                serverSide: true,
                responsive: true,
                info: true,
                paging: true,
                language: {
                    url: languageUrl,
                },
                "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                "pageLength": 10,
		    	dom: '<"row" <"col-sm-12 col-md-4"l><"col-sm-12 col-md-8"Bf>>rtip',
		        buttons: [
		            {
		                extend: 'copyHtml5',
		                exportOptions: {
		                    columns: function (idx, data, node) {
		                        let columnNames = $('#example1').DataTable().settings().init().columns.map(col => col.data);
                        		return !['actions', 'active'].includes(columnNames[idx]); 
		                    }
		                }
		            },
		            /*{
		                extend: 'csvHtml5',
		                exportOptions: {
		                    columns: function (idx, data, node) {
		                        let columnNames = $('#example1').DataTable().settings().init().columns.map(col => col.data);
                        		return !['actions', 'active'].includes(columnNames[idx]); 
		                    }
		                }
		            },*/
		            {
		                extend: 'pdfHtml5',
		                customize: function (doc) {
		                	let dataTable = $('#example1').DataTable();
		                    let columnCount = dataTable.columns().nodes().length; 
		                    let longText = false;

		                    dataTable.rows().nodes().each(function (row) {
		                        $(row).find('td').each(function () {
		                            if ($(this).text().length > 20) { 
		                                longText = true;
		                            }
		                        });
		                    });

		                    let orientation = (columnCount > 5 || longText) ? 'landscape' : 'portrait';
		                    doc.pageOrientation = orientation

		                	doc.defaultStyle = { fontSize: 10 };

		                	doc.content[1].table.body[0].forEach(function (headerCell) {
							    headerCell.alignment = 'left';
							    headerCell.fontSize = 10;
							});

		                	@if(session()->get('rtl', 1))
		                    doc.defaultStyle = {
		                        alignment: 'right',
		                        fontSize: 10
		                    };

		                    doc.content[1].table.direction = 'rtl';

		                    let pageTitle = document.title;
		                    doc.content[0].text = pageTitle.split(' ').reverse().join(' ');
		                    doc.content[0].alignment = 'center';
		                    doc.content[0].margin = [0, 10, 0, 20];

		                    let table = doc.content[1].table.body;
		                    table.forEach(function (row, index) {
		                        row.reverse(); 
		                    });

		                    doc.content[1].table.body.forEach(function (row) {
		                        row.forEach(function (cell) {
		                            cell.alignment = 'right';
		                            cell.text = cell.text.split(' ').reverse().join(' '); 
		                        });
		                    });
		                	@endif

		                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');

		                    doc.pageMargins = [10, 20, 10, 20];
		                },
		                exportOptions: {
		                    columns: function (idx, data, node) {
		                        let columnNames = $('#example1').DataTable().settings().init().columns.map(col => col.data);
                        		return !['actions', 'active'].includes(columnNames[idx]); 
		                    }
		                }
		            },
		            {
		                extend: 'excelHtml5',
		                exportOptions: {
		                    columns: function (idx, data, node) {
		                        let columnNames = $('#example1').DataTable().settings().init().columns.map(col => col.data);
                        		return !['actions', 'active'].includes(columnNames[idx]); 
		                    }
		                }
		            },
		            {
		                extend: 'print',
		                customize: function (win) {
		                	@if(session()->get('rtl', 1))
		                    $(win.document.body).css('direction', 'rtl'); 
		                    @endif
		                    $(win.document.body).css('font-size', '10px');
		                    $(win.document.body).find('table').addClass('compact').css('width', '100%');
		                },
		                exportOptions: {
		                    columns: function (idx, data, node) {
		                        let columnNames = $('#example1').DataTable().settings().init().columns.map(col => col.data);
                        		return !['actions', 'active'].includes(columnNames[idx]); 
		                    }
		                }
		            }
		        ],
                order: [[0, 'desc']],
		    });
		});
 	</script>
@endpush