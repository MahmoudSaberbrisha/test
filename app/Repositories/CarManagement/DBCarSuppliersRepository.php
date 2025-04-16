<?php

namespace App\Repositories\CarManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\CarSupplier;

class DBCarSuppliersRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return CarSupplier::select(['id', 'active', 'name'])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        $data = [
            'name' => $request['name']
        ];
        return CarSupplier::create($data);
    }

    public function findById($id, $locale = null)
    {
        return CarSupplier::findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $carSupplier = $this->findById($id, null);
        $carSupplier->name = $request['name'];
        return $carSupplier->save();
    }

    public function delete(int $id)
    {
        $carSupplier = $this->findById($id);
        return $carSupplier->delete();
    }

    public function active(int $id, string $value)
    {
        $carSupplier = $this->findById($id);
        if (!$carSupplier)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $carSupplier->active = ($value == 'true') ? 1 : 0;
        $carSupplier->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return CarSupplier::where('active', 1)
            ->get();
    }

}
