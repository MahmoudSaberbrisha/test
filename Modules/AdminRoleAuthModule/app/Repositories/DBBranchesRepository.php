<?php

namespace Modules\AdminRoleAuthModule\Repositories;

use Modules\AdminRoleAuthModule\RepositoryInterface\CrudRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Branch;

class DBBranchesRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        if (feature('regions-branches-feature'))
            return Branch::withTranslation()
                ->with(['region' => function ($query) {
                    $query->withTranslation();
                }])
                ->get();
        return Branch::withTranslation()
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
        if (feature('regions-branches-feature'))
            $data['region_id'] = $request['region_id'];
        return Branch::create($data);
    }

    public function findById($id, $locale = null)
    {
        if (feature('regions-branches-feature'))
            return Branch::withTranslation($locale)->with('region')->findOrFail($id);
        return Branch::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $branch = $this->findById($id, $request['locale']);
        $branch->translateOrNew($request['locale'])->name = $request['name'];
        if (feature('regions-branches-feature'))
            $branch->region_id = $request['region_id'];
        return $branch->save();
    }

    public function delete(int $id)
    {
        $branch = $this->findById($id);
        return $branch->delete();
    }

    public function active(int $id, string $value)
    {
        $branch = $this->findById($id);
        if (!$branch)
            return response()->json(array('type' => 'error', 'text' => __('Something went wrong during the process.')));
        $branch->active = ($value == 'true') ? 1 : 0;
        $branch->save();
        if ($value == 'true')
            return response()->json(array('type' => 'success', 'text' => __('Record activated successfully.')));
        return response()->json(array('type' => 'success', 'text' => __('Record deactivated successfully.')));
    }

    public function getActiveRecords()
    {
        if (feature('regions-branches-feature'))
            return Branch::withTranslation()
                ->with(['region' => function ($query) {
                    $query->withTranslation();
                }])
                ->where('active', 1)
                ->get();
        return Branch::withTranslation()
            ->select(['id', 'active'])
            ->get();
    }
}
