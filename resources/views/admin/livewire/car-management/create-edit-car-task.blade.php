<div x-data x-init="$nextTick(() => initializeDatePicker());">
    <div class="modal-body">
        <div class="row">
            <div class="col-4">
                <div class="form-group" wire:ignore>
                    <label class="form-label">{{ __('Car') }} <span class="tx-danger">*</span></label>
                    <select class="form-control select2" name="car_contract_id" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($contracts as $contract)
                            <option value="{{ $contract->id }}" {{ $car_contract_id == $contract->id ? 'selected' : '' }}>
                                {{ $contract->car_type }} - {{ $contract->car_supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">{{__('Date')}} <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="date" required value="{{ $date }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Currency') }}</label>
                    <select class="form-control" name="currency_id" required>
                        <option value="">{{__('Select')}}</option>
                        @foreach ($currencies as $currency)
                            <option value="{{$currency->id}}" {{ $currency_id == $currency->id ? 'selected' : '' }}>{{$currency->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Car Income') }} <span class="tx-danger">*</span></label>
                    <input class="form-control" id="car_income" name="car_income" placeholder="{{ __('Enter Car Income') }}" step=".5" required type="number" wire:model.live="car_income">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Paid') }} <span class="tx-danger">*</span></label>
                    <input class="form-control" id="paid" name="paid" placeholder="{{ __('Enter Paid Value') }}" step=".5" required type="number" wire:model.live="paid" wire:keyup.debounce.250ms="checkCarIncome">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Remain') }}</label>
                    <input class="form-control" id="remain" name="remain" readonly type="number" value="{{ max(0, $car_income - $paid) }}">
                </div>
            </div>

            <div class="col-12 mt-4 mr-1">
                <a href="javascript:void(0);" wire:click="addTaskInput" class="btn btn-primary mg-b-20">{{__('Add Task')}} <i class="typcn typcn-plus"></i></a>
                
                <!-- Show input fields only on create or when explicitly adding a task -->
                @if(!$carTask || (isset($showTaskInput) && $showTaskInput))
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <input class="form-control" name="time[]"type="time" wire:model="time" placeholder="{{ __('Time') }}"required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input class="form-control" name="from[]" type="text" wire:model="from" placeholder="{{ __('From') }}"required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input class="form-control" name="to[]" type="text" wire:model="to" placeholder="{{ __('To') }}" required>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if (!empty($taskInputs))
                @foreach ($taskInputs as $key => $task)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Time') }}</label>
                                        <input wire:model="taskInputs.{{$key}}.time" type="time" name="time[]" class="form-control" required value="{{ $task['time'] }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('From') }}</label>
                                        <input wire:model="taskInputs.{{$key}}.from" type="text" name="from[]" class="form-control" placeholder="{{ __('From') }}" required value="{{ $task['from'] }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('To') }}</label>
                                        <input wire:model="taskInputs.{{$key}}.to" type="text" name="to[]" class="form-control" placeholder="{{ __('To') }}" required value="{{ $task['to'] }}">
                                    </div>
                                </div>
                                <div class="col-1 mt-4">
                                    <a wire:click="removeTaskInput({{$key}})" class="remove-from-cart modal-effect mt-2" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="col-12 row mt-4 mr-1">
                <a href="javascript:void(0);" wire:click="addInput" class="btn btn-success mg-b-20">{{__('Add Expenses')}} <i class="typcn typcn-plus"></i></a>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" wire:model="car_expenses_id">
                            <option value="">{{__('Select')}}</option>
                            @foreach ($carExpenses as $expense)
                                <option value="{{$expense->id}}">{{$expense->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @if (!empty($inputs))
                @foreach ($inputs as $key => $input)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Expense Type') }}</label>
                                        <select wire:model.defer="inputs.{{$key}}.car_expenses_id" class="form-control" name="car_expenses_id[]" wire:change="checkExpensesExist({{$key}})" required>
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($carExpenses as $expense)
                                                <option value="{{$expense->id}}" {{ $input['car_expenses_id'] == $expense->id ? 'selected' : '' }}>
                                                    {{$expense->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Total') }}</label>
                                        <input wire:model.live.debounce.250ms="inputs.{{$key}}.total" type="number" step="0.5" name="total[]" class="form-control" placeholder="{{ __('Total') }}" required value="{{ $input['total'] }}">
                                    </div>
                                </div>

                                <div class="col-1 mt-4">
                                    <a wire:click="removeInput({{$key}})" class="remove-from-cart modal-effect mt-2" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex align-items-center mr-2">
                    <div class="me-2">
                        <label class="form-label">{{ __('Total Expenses') }}<span>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</span></label>
                    </div>
                    <div class="flex-grow-1">
                        <input type="number" min="0" name="total_expenses" class="form-control" wire:model="totalExpenses" readonly>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">{{__('Notes')}} </label>
                    <textarea rows="3" placeholder="{{__('Notes')}}" class="form-control" name="notes">{{ $notes }}</textarea>
                </div>
            </div>

            @include('adminroleauthmodule::includes.save-buttons')
        </div>
    </div>
</div>