<div>
    <div class="row mt-3 no-print">
        <div class="mb-3 col-4">
            <label for="supplierSelect">{{ __('Car Supplier') }}</label>
            <select wire:model="selectedSupplierId" wire:change="filterContracts" class="form-control">
                <option value="all">{{ __('All') }}</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-4">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="filterContracts">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-4">
            <label for="toDate">{{ __('Currency') }}</label>
            <select class="form-control" wire:model="currency_id" wire:change="filterContracts">
                <option value="all">{{__('All')}}</option>
                @foreach($currencies as $oneCurrency)
                <option value="{{$oneCurrency->id}}">{{$oneCurrency->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div wire:loading wire:target="filterContracts" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

    <div class="mt-3">
        <div class="row col-6">
            <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
            <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
        </div>
        <h5>{{ __('Contracts Due Amount') }}</h5>
        <table class="table table-bordered" border="1">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('Car Supplier') }}</th>
                    <th>{{ __('Car Type') }}</th>
                    <th>{{ __('Currency') }}</th>
                    <th>{{ __('Contract Start Date') }}</th>
                    <th>{{ __('Contract End Date') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Paid') }}</th>
                    <th>{{ __('Remain') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                    <tr>
                        <td>{{ $contract['car_supplier']['name'] }}</td>
                        <td>{{ $contract['car_type'] }}</td>
                        <td>{{ $contract['currency']['name'] }}</td>
                        <td>{{ $contract['contract_start_date'] }}</td>
                        <td>{{ $contract['contract_end_date'] }}</td>
                        <td>{{ number_format($contract['total'], 2) }}</td>
                        <td>{{ number_format($contract['paid'], 2) }}</td>
                        <td>{{ number_format($contract['remain'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">{{ __('No Data Found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                @foreach($currencyTotals as $currency => $totals)
                    <tr style="font-weight: bold; background-color: #f0f0f0;">
                        <td colspan="5">{{__('Total with')}} {{ $currency }}</td>
                        <td>{{ number_format($totals['total'], 2) }}</td>
                        <td>{{ number_format($totals['paid'], 2) }}</td>
                        <td>{{ number_format($totals['remain'], 2) }}</td>
                    </tr>
                @endforeach
            </tfoot>
        </table>
    </div>
</div>