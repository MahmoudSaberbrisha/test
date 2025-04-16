<?php

namespace App\Repositories\ClientsManagement;

use App\RepositoryInterface\CrudRepositoryInterface;
use App\Models\Client;

class DBClientsRepository implements CrudRepositoryInterface
{
    public function getAll()
    {
        return Client::get();
    }

    public function create(array $request)
    {
        return Client::create($request);
    }

    public function findById($id, $locale = null)
    {
        return Client::with('feed_backs')->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id);
        return $record->update($request);
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
        return Client::where('active', 1)->get();
    }

}
