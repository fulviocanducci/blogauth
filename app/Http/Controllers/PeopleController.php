<?php

namespace App\Http\Controllers;

use App\Http\Resources\DestroyResource;
use App\Models\People;
use Illuminate\Http\Request;
use App\Http\Resources\PeopleResource;
use App\Http\Resources\PeopleCollectionResource;
use stdClass;

class PeopleController extends Controller
{
    public function index()
    {
        return new PeopleCollectionResource(People::items());
    }

    public function store(Request $request)
    {
        $model = new People($request->all());
        if ($model->save()) {
            return (new PeopleResource($model))
                ->response()
                ->setStatusCode(201);
        }
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $model = People::find($id);
            if ($model) {
                return (new PeopleResource($model))
                    ->response()
                    ->setStatusCode(200);
            }
        }
    }

    public function update(Request $request, $id)
    {
        if (is_numeric($id)) {
            $model = People::find($id);
            if ($model) {
                $model->fill($request->all());
                $model->save();
                return (new PeopleResource($model))
                    ->response()
                    ->setStatusCode(201);
            }
        }
    }

    public function destroy($id)
    {
        if (is_numeric($id)) {
            $model = People::find($id);
            if ($model) {
                $result = new stdClass;
                $result->deleted = $model->delete();
                $result->found = !is_null($model);
                return new DestroyResource($result);
            }
        }
    }
}
