<?php

namespace App\Repositories\FinancialManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\Account;

class DBAccountsRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return Account::withTranslation()->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'active' => $request['active'],
            'icon' => $request['icon'],
            'code' => $request['code'],
            'account_type_id' => $request['account_type_id'],
            'parent_id' => $request['parent_id'],
            'is_payment' => $request['is_payment'],
            $locale => [
                'name' => $request['name'],
                'description' => $request['description']
            ]
        ];
        return Account::create($data);
    }

    public function findById($id, $locale = null)
    {
        return Account::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, $request['locale']);
        $record->translateOrNew($request['locale'])->name = $request['name'];
        $record->translateOrNew($request['locale'])->description = $request['description'];
        $record->active = $request['active'];
        $record->icon = $request['icon'];
        $record->code = $request['code'];
        $record->account_type_id = $request['account_type_id'];
        $record->parent_id = $request['parent_id'];
        $record->is_payment = $request['is_payment'];
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
        return Account::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
