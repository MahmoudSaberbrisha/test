<div>
    <div class="row mt-3 no-print">
        <div class="mb-3 col-2">
            <label for="fromDate">{{ __('From Date') }}</label>
            <input type="date" wire:model="fromDate" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('To Date') }}</label>
            <input type="date" wire:model="toDate" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Resevation Type') }}</label>
            <select class="form-control" wire:model="booking_type" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach(BOOKING_TYPES as $key => $type)
                <option value="{{$key}}">{{__($type)}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Currency') }}</label>
            <select class="form-control" wire:model="currency_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($currencies as $currency)
                <option value="{{$currency->id}}">{{$currency->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Is Confirmed') }}</label>
            <select class="form-control" wire:model="active" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                <option value="1">{{__('Yes')}}</option>
                <option value="0">{{__('No')}}</option>
            </select>
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
            <h5>{{ __('Bookings') }}</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Resevation Type') }}</th>
                        <th>{{ __('Booking Type') }}</th>
                        <th>{{ __('Sailing Boat') }}</th>
                        <th>{{ __('Total Hours') }}</th>
                        <th>{{ __('Client Supplier') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Price Person / Hour') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Discounted') }}</th>
                        <th>{{ __('Tax 14%') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Confirmed') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $data)
                        <tr>
                            <td>{{ $data->booking->booking_date->format('Y-m-d') }}</td>
                            <td>{{$data->booking->branch->name}}</td>
                            <td>{{__(BOOKING_TYPES[$data->booking->booking_type])}}</td>
                            <td>{{$data->booking->type->name}}</td>
                            <td>{{$data->booking->sailing_boat->name}}</td>
                            <td>{{$data->booking->total_hours}}</td>
                            <td>{{$data->client_supplier->name??'-'}}</td>
                            <td>{{$data->currency->name}}</td>
                            <td>{{$data->hour_member_price}}</td>
                            <td>{{$data->price}}</td>
                            <td>{{$data->discounted}}</td>
                            <td>{{$data->tax}}</td>
                            <td>{{$data->total}}</td>
                            <td>
                                @if($data->active == 1)
                                    <span class="text-success">&#10004;</span>
                                @else
                                    <span class="text-danger">&#10006;</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center">{{ __('No Data Found.') }}</td>
                        </tr>
                    @endforelse
                    @forelse($reportDataCurrency as $dataCurrency)
                        <tr style="background-color: #e1e4e7;">
                            <th colspan="8">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                            <td>{{$dataCurrency->total_hour_member_price}}</td>
                            <td>{{$dataCurrency->total_price}}</td>
                            <td>{{$dataCurrency->total_discount}}</td>
                            <td>{{$dataCurrency->total_tax}}</td>
                            <td>{{$dataCurrency->final_total}}</td>
                            <td></td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
