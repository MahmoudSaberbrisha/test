<?php

namespace App\Repositories\FinancialManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\AccountType;

class DBAccountTypesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return AccountType::withTranslation()
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
        return AccountType::create($data);
    }

    public function findById($id, $locale = null)
    {
        return AccountType::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, $request['locale']);
        $record->translateOrNew($request['locale'])->name = $request['name'];
        return $record->save();
    }

    public function delete(int $id)
    {
        $record = $this->findById($id);
        return $record->delete();
    }

    public function active(int $id, string $value)
    {
        $record = $this->findById($id);
        if (!$record)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $record->active = ($value == 'true') ? 1 : 0;
        $record->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return AccountType::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
