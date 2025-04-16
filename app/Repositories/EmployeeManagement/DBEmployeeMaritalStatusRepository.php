<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeMaritalStatus;

class DBEmployeeMaritalStatusRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeMaritalStatus::withTranslation()
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
        return EmployeeMaritalStatus::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeMaritalStatus::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $maritalStatus = $this->findById($id, $request['locale']);
        $maritalStatus->translateOrNew($request['locale'])->name = $request['name'];
        return $maritalStatus->save();
    }

    public function delete(int $id)
    {
        $maritalStatus = $this->findById($id);
        return $maritalStatus->delete();
    }

    public function active(int $id, string $value)
    {
        $maritalStatus = $this->findById($id);
        if (!$maritalStatus)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $maritalStatus->active = ($value == 'true') ? 1 : 0;
        $maritalStatus->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeMaritalStatus::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
