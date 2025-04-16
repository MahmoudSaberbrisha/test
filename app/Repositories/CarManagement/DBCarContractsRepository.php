<?php

namespace App\Repositories\CarManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\CarContract;
use App\Traits\ImageTrait;

class DBCarContractsRepository implements CrudRepositoryInterface
{
    use ImageTrait;

    public function getAll()
    {
        return CarContract::with(['car_supplier', 'currency', 'branch'])->get();
    }

    public function create(array $request)
    {
        if (isset($request['image'])) 
            $request['image'] = $this->verifyAndUpload($request, 'image', 'car_contracts');

        $data = CarContract::create($request);

        return $data;
    }

    public function findById($id, $locale = null)
    {
        return CarContract::findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $data = $this->findById($id, null);

        if (isset($request['image'])) {
            if ($data->getRawOriginal('image') != null) {
                $this->deleteFile('contracts/' . $data->getRawOriginal('image'));
            }
            $request['image'] = $this->verifyAndUpload($request, 'image', 'car_contracts');
        }

        return $data->update($request);
    }

    public function delete(int $id)
    {
        $data = $this->findById($id, null);
        if ($data->getRawOriginal('image') != null) 
            $this->deleteFile('contracts/'.$data->getRawOriginal('image'));
        return $data->delete();
    }

    public function active(int $id, string $value)
    {
        
    }

    public function getActiveRecords()
    {

    }

}
