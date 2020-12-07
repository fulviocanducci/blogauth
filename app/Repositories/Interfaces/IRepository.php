<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function query(): Builder;
    public function create(array $attributes): Model;
    public function update(array $attributes): int;
    public function get(int $id): Model;
    public function all(array $columns = ['*']): Collection;
    public function delete(int $id): int;
}
