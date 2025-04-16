<?php

namespace App\Repositories\Settings;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\SailingBoat;

class DBSailingBoatsRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return SailingBoat::withTranslation()
            ->with(['branch' => function ($query) {
                $query->withTranslation(); 
            }])
            ->select(['id', 'active', 'branch_id'])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'branch_id' => $request['branch_id'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return SailingBoat::create($data);
    }

    public function findById($id, $locale = null)
    {
        return SailingBoat::withTranslation($locale)->with('branch')->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, $request['locale']);
        $record->translateOrNew($request['locale'])->name = $request['name'];
        $record->branch_id = $request['branch_id'];
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
        return SailingBoat::withTranslation()
            ->with(['branch' => function ($query) {
                $query->withTranslation(); 
            }])
            ->where('active', 1)
            ->get();
    }

}
