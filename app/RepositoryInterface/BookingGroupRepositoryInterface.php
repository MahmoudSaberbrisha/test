<?php

namespace App\RepositoryInterface;

interface BookingGroupRepositoryInterface {

    public function getAll();

    public function create(array $request);

    public function findById(int $id);

    public function update(int $id, array $request);

    public function delete(int $id);

}
