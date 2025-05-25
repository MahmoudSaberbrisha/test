<a class="remove-from-cart modal-effect" href="javascript:void(0);" title="{{ __('Delete') }}" data-effect="effect-scale"
    onclick="$('#modal-danger form').attr('action', '{{ route(auth()->getDefaultDriver() . '.bookings.destroy', $id) }}'); $('#modal-danger form').attr('method', 'post');"
    data-toggle="modal" data-target="#modal-danger"><i class="fa fa-trash"></i></a>
<a class="btn-edit" href="javascript:void(0);" onclick='Livewire.dispatch("openModal", {id: "{{ $id }}"} );'
    data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-edit"></i></a>
<a class="btn-sm-success" href="{{ route(auth()->getDefaultDriver() . '.client-booking', $id) }}" data-placement="top"
    title="{{ __('Add Group') }}"><i class="fa fa-plus"></i></a>
<a class="btn-sm-dark" target="_blank"
    href="{{ route(auth()->getDefaultDriver() . '.print-reservation-data-pdf', $id) }}" data-placement="top"
    title="{{ __('Reservation Data PDF') }}"> <i class="fa fa-print"></i> </a>
<a class="btn-sm-dark excel-export-btn" href="javascript:void(0);" data-id="{{ $id }}" data-placement="top"
    title="{{ __('Reservation Data EXCEL') }}" onclick="exportToExcel()"> <i class="fas fa-file-excel text-success"></i>
</a>
<script>
    function exportToExcel() {
        let table = $('#example1').DataTable();
        table.button('.buttons-excel').trigger();
        return false;
    }
</script>

<a class="btn-sm-dark" target="_blank" href="{{ route(auth()->getDefaultDriver() . '.print-cruise-statement-pdf', $id) }}" data-placement="top" title="{{ __('Cruise Statement PDF') }}"> <i class="fas fa-file-pdf text-danger"></i> </a>
<a class="btn-sm-dark" target="_blank" href="{{ route(auth()->getDefaultDriver().'.print-cruise-statement-excel', $id) }}" data-placement="top" title="{{ __('Cruise Statement EXCEL') }}"> <i class="fas fa-file-csv text-info"></i> </a>
