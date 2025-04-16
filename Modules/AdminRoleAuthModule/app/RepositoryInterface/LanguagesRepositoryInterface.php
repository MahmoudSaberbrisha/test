<?php

namespace Modules\AdminRoleAuthModule\RepositoryInterface;

interface LanguagesRepositoryInterface {

    public function getAll();

    public function create(array $request);

    public function findById(int $id);

    public function update(int $id, array $request);

    public function delete(int $id);

    public function active(int $id, string $value);

    public function changeRtl(int $id, string $value);

    public function getActiveLanguages();

    public function getDefaultLanguage();
}
