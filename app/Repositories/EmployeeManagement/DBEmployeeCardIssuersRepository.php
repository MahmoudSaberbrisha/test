<?php

namespace App\Repositories\EmployeeManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\EmployeeManagement\EmployeeCardIssuer;

class DBEmployeeCardIssuersRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return EmployeeCardIssuer::withTranslation()
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
        return EmployeeCardIssuer::create($data);
    }

    public function findById($id, $locale = null)
    {
        return EmployeeCardIssuer::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        
        $cardIssuer = $this->findById($id, $request['locale']);
        $cardIssuer->translateOrNew($request['locale'])->name = $request['name'];
        return $cardIssuer->save();
    }

    public function delete(int $id)
    {
        $cardIssuer = $this->findById($id);
        return $cardIssuer->delete();
    }

    public function active(int $id, string $value)
    {
        $cardIssuer = $this->findById($id);
        if (!$cardIssuer)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $cardIssuer->active = ($value == 'true') ? 1 : 0;
        $cardIssuer->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return EmployeeCardIssuer::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
