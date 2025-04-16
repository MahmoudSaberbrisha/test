<?php

namespace Modules\AdminRoleAuthModule\Repositories;

use Modules\AdminRoleAuthModule\RepositoryInterface\CrudRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Region;

class DBRegionsRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return Region::withTranslation()
            ->with(['branches' => function ($query) {
                $query->withTranslation(); 
            }])
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
        return Region::create($data);
    }

    public function findById($id, $locale = null)
    {
        return Region::withTranslation($locale)->with('branches')->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $region = $this->findById($id, $request['locale']);
        $region->translateOrNew($request['locale'])->name = $request['name'];
        return $region->save();
    }

    public function delete(int $id)
    {
        $region = $this->findById($id);
        return $region->delete();
    }

    public function active(int $id, string $value)
    {
        $region = $this->findById($id);
        if (!$region)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $region->active = ($value == 'true') ? 1 : 0;
        $region->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return Region::withTranslation()
            ->with(['branches' => function ($query) {
                $query->withTranslation(); 
            }])
            ->where('active', 1)
            ->get();
    }

}
