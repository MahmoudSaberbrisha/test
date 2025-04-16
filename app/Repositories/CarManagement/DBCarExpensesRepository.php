<?php

namespace App\Repositories\CarManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\CarExpenses;

class DBCarExpensesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return CarExpenses::withTranslation()
            ->select(['id', 'active'])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            $locale => [
                'name' => $request['name']
            ]
        ];
        return CarExpenses::create($data);
    }

    public function findById($id, $locale = null)
    {
        return CarExpenses::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $expenses = $this->findById($id, $request['locale']);
        $expenses->translateOrNew($request['locale'])->name = $request['name'];
        return $expenses->save();
    }

    public function delete(int $id)
    {
        $expenses = $this->findById($id);
        return $expenses->delete();
    }

    public function active(int $id, string $value)
    {
        $expenses = $this->findById($id);
        if (!$expenses)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $expenses->active = ($value == 'true') ? 1 : 0;
        $expenses->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return CarExpenses::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
