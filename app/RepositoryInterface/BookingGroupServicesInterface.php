<?php

namespace App\RepositoryInterface;

interface BookingGroupServicesInterface {

    public function getAll();

    public function create(array $request);

    public function findById(int $id);

    public function update(array $request);

    public function delete(int $id);

    public function deleteService(int $id);

    public function findOneService(int $id);
    
    public function getBookingsWithoutServices();
}
