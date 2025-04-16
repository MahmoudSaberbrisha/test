<?php

namespace Modules\AdminRoleAuthModule\RepositoryInterface;

interface CrudRepositoryInterface {

    public function getAll();

    public function create(array $request);

    public function findById(int $id, $locale = null);

    public function update(int $id, array $request);

    public function delete(int $id);

    public function active(int $id, string $value);

    public function getActiveRecords();
}
