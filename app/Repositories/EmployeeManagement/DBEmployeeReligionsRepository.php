<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeReligion;

class DBEmployeeReligionsRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeReligion::withTranslation()
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
        return EmployeeReligion::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeReligion::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $religion = $this->findById($id, $request['locale']);
        $religion->translateOrNew($request['locale'])->name = $request['name'];
        return $religion->save();
    }

    public function delete(int $id)
    {
        $religion = $this->findById($id);
        return $religion->delete();
    }

    public function active(int $id, string $value)
    {
        $religion = $this->findById($id);
        if (!$religion)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $religion->active = ($value == 'true') ? 1 : 0;
        $religion->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeReligion::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
