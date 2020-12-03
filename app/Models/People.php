<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'peoples';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function scopeItems($model)
    {
        return $model->select('id', 'name')->get();
    }
}
