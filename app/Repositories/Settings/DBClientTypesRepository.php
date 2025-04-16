<?php

namespace App\Repositories\Settings;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\ClientType;

class DBClientTypesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return ClientType::withTranslation()->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'discount_type' => $request['discount_type'],
            'discount_value' => $request['discount_value'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return ClientType::create($data);
    }

    public function findById($id, $locale = null)
    {
        return ClientType::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, $request['locale']);
        $record->discount_type = $request['discount_type'];
        $record->discount_value = $request['discount_value'];
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
        return ClientType::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
