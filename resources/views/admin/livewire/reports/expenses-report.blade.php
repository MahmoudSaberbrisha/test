<div>
    <div class="row mt-3 no-print">
        <div class="mb-3 col-2">
            <label for="from_date">{{ __('From Date') }}</label>
            <input type="date" wire:model="from_date" wire:change="filterExpenses" class="form-control">
        </div>

        <div class="mb-3 col-2">
            <label for="to_date">{{ __('To Date') }}</label>
            <input type="date" wire:model="to_date" wire:change="filterExpenses" class="form-control">
        </div>

        <div class="mb-3 col-2">
            <label for="expenseTypeSelect">{{ __('Expenses Types') }}</label>
            <select wire:model="selectedExpenseType" wire:change="filterExpenses" class="form-control">
                <option value="all">{{ __('All') }}</option>
                @foreach ($expenseTypes as $expenseType)
                    <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="filterExpenses">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-2">
            <label for="toDate">{{ __('Currency') }}</label>
            <select class="form-control" wire:model="currency_id" wire:change="filterExpenses">
                <option value="all">{{__('All')}}</option>
                @foreach($currencies as $currency)
                <option value="{{$currency->id}}">{{$currency->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div wire:loading wire:target="filterExpenses" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

    @if($from_date || $to_date)
        <div class="mt-3">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Expenses') }}</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Expenses Types') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Value') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date }}</td>
                            <td>{{ $expense->branch->name??'-' }}</td>
                            <td>{{ $expense->expenses_type->name }}</td>
                            <td>{{ $expense->note }}</td>
                            <td>{{ $expense->currency->name }}</td>
                            <td>{{ $expense->value }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('No Data Found.') }}</td>
                        </tr>
                    @endforelse
                    @forelse($reportDataCurrency as $dataCurrency)
                        <tr style="background-color: #e1e4e7;">
                            <th colspan="5">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                            <td>{{$dataCurrency->total}}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
