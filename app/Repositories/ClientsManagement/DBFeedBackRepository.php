<?php

namespace App\Repositories\ClientsManagement;

use App\RepositoryInterface\FeedBackRepositoryInterface;
use App\Models\FeedBack;

class DBFeedBackRepository implements FeedBackRepositoryInterface
{
    public function getAll()
    {
        return FeedBack::with([
            'experience_type' => function ($query) {
                $query->withTranslation(); 
            },
            'client',
            'booking_group'
        ])->get();
    }

    public function create(array $request)
    {
        return FeedBack::create($request);
    }

    public function findById($id)
    {
        return FeedBack::findOrFail($id);
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

}
