<div>
    <div class="row mt-3 no-print">
        <div class="mb-3 col-4">
            <label for="expenseTypeSelect">{{ __('Car') }}</label>
            <select wire:model="selectedContractId" wire:change="filterCarExpenses" class="form-control">
                <option value="all">{{ __('All') }}</option>
                @foreach ($contracts as $contract)
                    <option value="{{ $contract->id }}">
                        {{ $contract->car_type }} - {{ $contract->car_supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-4">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="filterCarExpenses">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-4">
            <label for="toDate">{{ __('Currency') }}</label>
            <select class="form-control" wire:model="currency_id" wire:change="filterCarExpenses">
                <option value="all">{{__('All')}}</option>
                @foreach($currencies as $oneCurrency)
                <option value="{{$oneCurrency->id}}">{{$oneCurrency->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div wire:loading wire:target="filterCarExpenses" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{ __('Loading...') }}</span>
        </div>
    </div>

    <div class="mt-3">
        <div class="row col-6">
            <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
            <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
        </div>
        <h5>{{ __('Car Expenses') }}</h5>
        <table class="table table-bordered" border="1">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('Car Type') }}</th>
                    <th>{{ __('Car Supplier') }}</th>
                    <th>{{ __('Currency') }}</th>
                    <th>{{ __('Date') }}</th>
                    @foreach ($expenseTypes as $expenseType)
                        <th>{{ $expenseType->name }}</th>
                    @endforeach
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($carExpenses as $expenses)
                    <tr>
                        <td>{{ $expenses['car_contract']['car_type'] }}</td>
                        <td>{{ $expenses['car_contract']['car_supplier']['name'] }}</td>
                        <td>{{ $expenses['currency'] }}</td>
                        <td>{{ $expenses['date'] }}</td>
                        @foreach ($expenseTypes as $expenseType)
                            <td>{{ number_format($expenses['expense_types'][$expenseType->name] ?? 0, 2) }}</td>
                        @endforeach
                        <td>{{ number_format($expenses['total_expenses'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($expenseTypes) + 5 }}" class="text-center">{{ __('No Data Found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                @foreach ($currencyTotals as $currency => $totals)
                    <tr style="font-weight: bold; background-color: #f0f0f0;">
                        <td colspan="3">{{__('Total with')}} {{ $currency }}</td>
                        <td></td>
                        @foreach ($expenseTypes as $expenseType)
                            <td>{{ number_format($totals['expense_types'][$expenseType->name] ?? 0.00, 2) }}</td>
                        @endforeach
                        <td>{{ number_format($totals['total'], 2) }}</td>
                    </tr>
                @endforeach
            </tfoot>
        </table>
    </div>
</div>