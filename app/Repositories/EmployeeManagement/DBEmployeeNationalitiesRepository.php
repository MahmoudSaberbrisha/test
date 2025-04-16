<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeNationality;

class DBEmployeeNationalitiesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeNationality::withTranslation()
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
        return EmployeeNationality::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeNationality::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $nationality = $this->findById($id, $request['locale']);
        $nationality->translateOrNew($request['locale'])->name = $request['name'];
        return $nationality->save();
    }

    public function delete(int $id)
    {
        $nationality = $this->findById($id);
        return $nationality->delete();
    }

    public function active(int $id, string $value)
    {
        $nationality = $this->findById($id);
        if (!$nationality)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $nationality->active = ($value == 'true') ? 1 : 0;
        $nationality->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeNationality::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
