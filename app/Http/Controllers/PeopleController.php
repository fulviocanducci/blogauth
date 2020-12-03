<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        return response()->json(People::all());
    }

    public function store(Request $request)
    {
        $model = new People($request->all());
        $model->save();
        return response()->json($model);
    }

    public function show($id)
    {
        $model = People::find($id);
        return response()->json($model);
    }

    public function update(Request $request, $id)
    {
        $model = People::find($id);
        $model->fill($request->all());
        $model->save();
        return response()->json($model);
    }

    public function destroy($id)
    {
        $model = People::find($id);
        if ($model) {
            return response()->json(['deleted' => $model->delete()]);
        }
    }
}
