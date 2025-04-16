<div x-data x-init="$nextTick(() => initSelect2Drop());">
    <div class="row mt-3 no-print">
        <div class="mb-3 col-3">
            <label for="fromDate">{{ __('From Date') }}</label>
            <input type="date" wire:model="fromDate" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-3">
            <label for="toDate">{{ __('To Date') }}</label>
            <input type="date" wire:model="toDate" wire:change="getReportData" class="form-control">
        </div>

        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
            <div class="form-group w-100" wire:ignore>
                <label class="form-label mb-2">{{__('Client Suppliers')}}</label>
                <select class="form-control select2 js-example-basic-single" wire:model="client_supplier_id">
                    <option value="all" selected>{{ __('All') }}</option>
                    @foreach($clientSuppliers as $clientSupplier)
                        <option value="{{ $clientSupplier->id }}">{{ $clientSupplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="getReportData" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

    @if($reportData)
        <div class="mt-3">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Credit Sales') }}</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Resevation Type') }}</th>
                        <th>{{ __('Booking Type') }}</th>
                        <th>{{ __('Client Supplier') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Price Person / Hour') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Paid') }}</th>
                        <th>{{ __('Remain') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $data)
                        <tr>
                            <td>{{ $data->booking->booking_date->format('Y-m-d') }}</td>
                            <td>{{$data->booking->branch->name}}</td>
                            <td>{{__(BOOKING_TYPES[$data->booking->booking_type])}}</td>
                            <td>{{$data->booking->type->name}}</td>
                            <td>{{$data->client_supplier->name??'-'}}</td>
                            <td>{{$data->currency->name}}</td>
                            <td>{{$data->hour_member_price}}</td>
                            <td>{{$data->total}}</td>
                            <td>{{$data->paid}}</td>
                            <td>{{$data->remain}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">{{ __('No Data Found.') }}</td>
                        </tr>
                    @endforelse
                    @forelse($reportDataCurrency as $dataCurrency)
                        <tr style="background-color: #e1e4e7;">
                            <th colspan="6">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                            <td>{{$dataCurrency->total_hour_member_price}}</td>
                            <td>{{$dataCurrency->final_total}}</td>
                            <td>{{$dataCurrency->total_paid}}</td>
                            <td>{{$dataCurrency->total_remain}}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('js')
    <script type="text/javascript">
        function initSelect2Drop() {
            $('.js-example-basic-single').select2({
                language: "{{ app()->getLocale() }}",
                dir: "{{ session()->get('rtl', 1)?'rtl':'ltr' }}"
            });
        }
        $('.js-example-basic-single').on('change', function (e) {
            const selectedId = $(this).val();
            @this.set('client_supplier_id', selectedId);
            @this.call('getReportData');
        });
    </script>
@endpush