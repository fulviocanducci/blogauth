<?php

namespace App\Repositories;

use App\Models\People;
use App\Repositories\Abstracts\AbstractRepository;

class RepositoryPeople extends AbstractRepository
{
    public function __construct(People $model)
    {
        parent::__construct($model);
    }
}
