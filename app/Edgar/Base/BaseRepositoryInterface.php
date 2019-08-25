<?php

namespace App\Edgar\Base;

interface BaseRepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes, int $id);

    public function all(array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc');

    public function findOneOrFail($id);

    public function findBy(array $data);

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);

    public function delete(int $id);
}
