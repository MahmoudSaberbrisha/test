<?php

namespace App\Repositories;

use App\RepositoryInterface\ExtraServicesInterface;
use App\Models\ExtraService;
use DB;

class DBExtraServicesRepository implements ExtraServicesInterface
{
    public function getAll()
    {
        return ExtraService::withTranslation()
            ->with(['parent' => function ($query) {
                $query->withTranslation(); 
            }, 'children' => function ($query) {
                $query->withTranslation(); 
            }])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'parent_id' => $request['parent_id'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return ExtraService::create($data);
    }

    public function findById($id, $locale = null)
    {
        return ExtraService::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id, $request['locale']);
        $record->translateOrNew($request['locale'])->name = $request['name'];
        $record->parent_id = $request['parent_id'];
        return $record->save();
    }

    public function delete(int $id)
    {
        $record = $this->findById($id);
        $record->children()->delete();
        return $record->delete();
    }

    public function active(int $id, string $value)
    {
        $record = $this->findById($id);
        if (!$record)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $record->active = ($value == 'true') ? 1 : 0;
        $record->save();
        $record->children()->each(function ($child) use ($value) {
            $child->active = ($value == 'true') ? 1 : 0;
            $child->save();
        });
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return ExtraService::withTranslation()
            ->with(['parent'=> function ($query) {
                $query->withTranslation(); 
            }, 'children'=> function ($query) {
                $query->withTranslation(); 
            }])
            ->where('active', 1)
            ->get();
    }

    public function getParents()
    {
        return ExtraService::withTranslation()->parents()->get();
    }

    public function getActiveParents()
    {
        return ExtraService::withTranslation()
            ->with(['children' => function ($query) {
                $query->withTranslation(); 
                $query->with(['parent' => function ($q) {
                    $q->withTranslation(); 
                }]);
                $query->where('active', 1);
            }])
            ->parents() 
            ->where('active', 1) 
            ->where(function ($query) {
                $query->has('children') 
                    ->orWhereDoesntHave('children'); 
            })
            ->get();
    }
}
