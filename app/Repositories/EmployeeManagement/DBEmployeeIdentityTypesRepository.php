<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeIdentityType;

class DBEmployeeIdentityTypesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeIdentityType::withTranslation()
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
        return EmployeeIdentityType::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeIdentityType::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $identityType = $this->findById($id, $request['locale']);
        $identityType->translateOrNew($request['locale'])->name = $request['name'];
        return $identityType->save();
    }

    public function delete(int $id)
    {
        $identityType = $this->findById($id);
        return $identityType->delete();
    }

    public function active(int $id, string $value)
    {
        $identityType = $this->findById($id);
        if (!$identityType)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $identityType->active = ($value == 'true') ? 1 : 0;
        $identityType->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeIdentityType::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
