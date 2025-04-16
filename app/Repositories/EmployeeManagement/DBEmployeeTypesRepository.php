<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeType;

class DBEmployeeTypesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeType::withTranslation()
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
        return EmployeeType::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeType::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $type = $this->findById($id, $request['locale']);
        $type->translateOrNew($request['locale'])->name = $request['name'];
        return $type->save();
    }

    public function delete(int $id)
    {
        $type = $this->findById($id);
        return $type->delete();
    }

    public function active(int $id, string $value)
    {
        $type = $this->findById($id);
        if (!$type)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $type->active = ($value == 'true') ? 1 : 0;
        $type->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeType::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
