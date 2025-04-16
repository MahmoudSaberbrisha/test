<?php

namespace App\Repositories\Settings;
use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\ExperienceType;

class DBExperienceTypeRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return ExperienceType::withTranslation()
            ->select(['id', 'active', 'color'])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'color' => $request['color'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return ExperienceType::create($data);
    }

    public function findById($id, $locale = null)
    {
        return ExperienceType::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $data = $this->findById($id, $request['locale']);
        $data->translateOrNew($request['locale'])->name = $request['name'];
        $data->color = $request['color'];
        return $data->save();
    }

    public function delete(int $id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }

    public function active(int $id, string $value)
    {
        $data = $this->findById($id);
        if (!$data)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $data->active = ($value == 'true') ? 1 : 0;
        $data->save();
        if ($value == 'true')
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return ExperienceType::withTranslation()
            ->where('active', 1)
            ->get();
    }

}
