<?php

namespace App\Livewire\CarManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\Models\CarTask;
use App\Models\CarTaskExpense;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;

class CreateEditCarTask extends Component
{
    private $carContractRepository, $currencyRepository;

    public $contracts;
    public $inputs = [];
    public $carExpenses = [];
    public $car_expenses_id = null;
    public $carTask = null;
    public $totalExpenses = 0;
    public $currencies = [];
    public $defaultCurrency = null;
    public $car_income = 0;
    public $paid = 0;
    public $car_contract_id = null;
    public $currency_id = null;
    public $date = null;
    public $notes = null;
    public $taskInputs = [];
    public $time = '';
    public $from = '';
    public $to = '';

    public function __construct()
    {
        $this->carContractRepository = App::make('CarContractCrudRepository');
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
    }

    public function mount($carTaskId = null)
    {
        $this->contracts = $this->carContractRepository->getAll();
        $this->currencies = $this->currencyRepository->getAll();
        $this->defaultCurrency = $this->currencyRepository->getDefaultCurrency();
        $this->carExpenses = App::make('CarExpensesCrudRepository')->getActiveRecords();

        if ($carTaskId) {
            $this->carTask = CarTask::with(['carTaskExpenses', 'carTaskDetails'])->findOrFail($carTaskId);
        }

        $this->car_contract_id = old('car_contract_id', $this->carTask?->car_contract_id);
        $this->currency_id = old('currency_id', $this->carTask?->currency_id ?? ($this->defaultCurrency ? $this->defaultCurrency->id : null));
        $this->car_income = old('car_income', $this->carTask?->car_income ?? 0);
        $this->paid = old('paid', $this->carTask?->paid ?? 0);
        $this->date = old('date', $this->carTask?->date);
        $this->notes = old('notes', $this->carTask?->notes);

        if (old('car_expenses_id')) {
            $this->inputs = [];
            foreach (old('car_expenses_id') as $key => $expenseId) {
                $this->inputs[] = [
                    'car_expenses_id' => $expenseId,
                    'total' => old('total.' . $key),
                ];
            }
        } elseif ($this->carTask) {
            $this->inputs = $this->carTask->carTaskExpenses->map(function ($expense) {
                return [
                    'car_expenses_id' => $expense->car_expenses_id,
                    'total' => $expense->total,
                ];
            })->toArray();
        }

        if (old('time')) {
            $this->taskInputs = [];
            foreach (old('time') as $key => $time) {
                $this->taskInputs[] = [
                    'time' => $time,
                    'from' => old('from.' . $key),
                    'to' => old('to.' . $key),
                ];
            }
        } elseif ($this->carTask) {
            $this->taskInputs = $this->carTask->carTaskDetails->map(function ($detail) {
                return [
                    'time' => $detail->time,
                    'from' => $detail->from,
                    'to' => $detail->to,
                ];
            })->toArray();
        }

        $this->calculateTotalExpenses();
    }

    public function addInput()
    {
        if ($this->car_expenses_id) {
            $expense = $this->getCarExpense($this->car_expenses_id);

            $existingKey = collect($this->inputs)->search(function ($item) {
                return $item['car_expenses_id'] == $this->car_expenses_id;
            });

            if ($existingKey !== false) {
                $this->inputs[$existingKey]['total'] += $expense->default_value ?? 0;
            } else {
                $this->inputs[] = [
                    'car_expenses_id' => $this->car_expenses_id,
                    'total' => $expense->default_value ?? 0,
                ];
            }

            $this->calculateTotalExpenses();
        }
    }

    public function checkExpensesExist($key)
    {
        $existingKey = collect($this->inputs)->contains('car_expenses_id', $this->inputs[$key]['car_expenses_id']);
        if($existingKey) {
            $this->removeInput($key);
            $this->alertMessage(__('You added this type before.'), 'error');
        }
    }

    public function removeInput($key)
    {
        if (isset($this->inputs[$key])) {
            unset($this->inputs[$key]);
            $this->inputs = array_values($this->inputs);
            $this->calculateTotalExpenses();
        }
    }

    public function calculateTotalExpenses()
    {
        $this->totalExpenses = collect($this->inputs)->sum('total');
    }

    public function updatedInputs($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 3 && $parts[1] === 'total') {
            $index = $parts[0];
            $this->inputs[$index]['total'] = $value;
            $this->calculateTotalExpenses();
        }
        
        $this->calculateTotalExpenses();
    }

    public function getCarExpense($id)
    {
        return collect($this->carExpenses)->firstWhere('id', $id);
    }

    public function checkCarIncome()
    {
        if ($this->paid > $this->car_income) {
            $this->paid = $this->car_income;
            return $this->alertMessage(__('Car Income Is ') . $this->car_income . __(' You Can\'t Exceed This Value'), 'error');
        }
    }

    public function alertMessage($message, $type)
    {
        $this->dispatch(
            'alert',
            ['type' => $type,  'message' => $message]
        );
    }

    public function addTaskInput()
    {
        $this->taskInputs[] = [
            'time' => $this->time,
            'from' => $this->from,
            'to' => $this->to,
        ];
        $this->reset(['time', 'from', 'to']);
    }

    public function removeTaskInput($key)
    {
        if (isset($this->taskInputs[$key])) {
            unset($this->taskInputs[$key]);
            $this->taskInputs = array_values($this->taskInputs);
        }
    }

    public function render(): View
    {
        return view('admin.livewire.car-management.create-edit-car-task');
    }
}