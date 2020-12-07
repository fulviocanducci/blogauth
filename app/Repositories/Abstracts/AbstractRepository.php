<?php

namespace App\Repositories\Abstracts;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements IRepository
{
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update(array $attributes): int
    {
        return $this->model->newQuery()->update($attributes);
    }

    public function get(int $id): Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function delete(int $id): int
    {
        $model = $this->model->newQuery()->where('id', $id)->first();
        return $model->delete();
    }
}
