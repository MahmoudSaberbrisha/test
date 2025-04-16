<?php

namespace App\RepositoryInterface;

interface ExpenseRepositoryInterface {

    public function getAll();

    public function create(array $request);

    public function findById(int $id, $locale = null);

    public function update(int $id, array $request);

    public function delete(int $id);
    
}
