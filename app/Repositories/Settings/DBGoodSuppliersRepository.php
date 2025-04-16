<?php

namespace App\Repositories\Settings;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\GoodSupplier;

class DBGoodSuppliersRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return GoodSupplier::get();
    }

    public function create(array $request)
    {
        return GoodSupplier::create($request);
    }

    public function findById($id, $locale = null)
    {
        return GoodSupplier::findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id);
        $record->name = $request['name'];
        $record->phone = $request['phone'];
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
        return GoodSupplier::where('active', 1)->get();
    }

}
