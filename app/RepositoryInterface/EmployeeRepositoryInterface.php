<?php

namespace App\RepositoryInterface;

interface EmployeeRepositoryInterface
{
    public function getAll();

    public function create(array $request);

    public function findById($id);

    public function update(int $id, array $request);
    
    public function delete(int $id);
}