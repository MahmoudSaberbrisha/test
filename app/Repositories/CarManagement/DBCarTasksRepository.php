<?php

namespace App\Repositories\CarManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\CarTask;
use App\Models\CarTaskExpense;
use App\Models\CarTaskDetails;

class DBCarTasksRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return CarTask::with(['car_contract.car_supplier', 'carTaskExpenses' , 'car_contract.branch'])->get();
    }

    public function create(array $request)
    {
        $data['car_contract_id'] = $request['car_contract_id'];
        $data['currency_id'] = $request['currency_id'];
        $data['date'] = $request['date'];
        $data['car_income'] = $request['car_income'];
        $data['paid'] = $request['paid'];
        $data['notes'] = $request['notes'];

        $carTask = CarTask::create($request);
        if (!empty($request['car_expenses_id'])) {
            $this->createCarTaskExpenses($carTask->id, $request);
        }
        if (!empty($request['time'])) {
            $this->createCarTaskDetails($carTask->id, $request);
        }
        return $carTask;
    }

    public function findById($id, $locale = null)
    {
        return CarTask::findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, null);

        $data['car_contract_id'] = $request['car_contract_id'];
        $data['currency_id'] = $request['currency_id'];
        $data['date'] = $request['date'];
        $data['car_income'] = $request['car_income'];
        $data['total_expenses'] = $request['total_expenses'] ?? 0;
        $data['paid'] = $request['paid'];
        $data['notes'] = $request['notes'];

        $record->update($data);
        $record->carTaskExpenses()->delete();
        if (isset($request['car_expenses_id'])) {
            $this->createCarTaskExpenses($id, $request);
        }
        $record->carTaskDetails()->delete();
        if (isset($request['time'])) {
            $this->createCarTaskDetails($id, $request);
        }
        return $record;
    }

    public function delete(int $id)
    {
        $data = $this->findById($id, null);
        return $data->delete();
    }

    public function active(int $id, string $value)
    {
        
    }

    public function getActiveRecords()
    {

    }

    public function createCarTaskDetails(int $carTaskId, array $request)
    {
        foreach ($request['time'] as $key => $time) {
            $data = [];
            $data['car_task_id'] = $carTaskId;
            $data['time'] = $time;
            $data['from'] = $request['from'][$key];
            $data['to'] = $request['to'][$key];
            
            CarTaskDetails::create($data);
        }
    }

    public function createCarTaskExpenses(int $CarTaskId, array $request)
    {
        foreach ($request['car_expenses_id'] as $key => $car_expenses_id) {
            $data = [];
            $data['car_task_id'] = $CarTaskId;
            $data['car_expenses_id'] = $car_expenses_id;
            $data['total'] = $request['total'][$key];
            
            CarTaskExpense::create($data);
        }
    }
}