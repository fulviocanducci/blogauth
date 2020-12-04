<?php

namespace App\Http\Controllers;

use App\Http\Resources\DestroyResource;
use App\Models\People;
use Illuminate\Http\Request;
use App\Http\Resources\PeopleResource;
use App\Http\Resources\PeopleCollectionResource;
use App\Traits\ValidationMake;
use stdClass;

class PeopleController extends Controller
{
    use ValidationMake;

    /**
     * @OA\Schema(
     *   schema="PeopleCreate",
     *   @OA\Property(
     *     property="name",
     *     type="string"
     *   )
     * )
     */

    /**
     * @OA\Schema(
     *   schema="PeopleUpdate",
     *   @OA\Property(
     *     property="id",
     *     type="integer"
     *   ),
     *   @OA\Property(
     *     property="name",
     *     type="string"
     *   )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/people",
     *     @OA\Response(response="200", description="List of People"),
     *     tags={"People"},
     *     operationId="getProjectsList",
     *     security={{"apiAuth":{}}}
     * )
     */
    public function index()
    {
        return new PeopleCollectionResource(People::items());
    }

    /**
     * @OA\Get(
     *     path="/api/people/{id}",
     *     @OA\Response(
     *          response="200",
     *          description="Show People By id",
     *          @OA\JsonContent(ref="#/components/schemas/PeopleUpdate")
     *     ),
     *     tags={"People"},
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/people",
     *     tags={"People"},
     *     security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PeopleCreate")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PeopleUpdate")
     *       ),
     *  ),
     * )
     */
    public function store(Request $request)
    {
        $validated = $this->valid($request, ['name' => 'required']);
        if ($validated->fails()) {
            return $validated->errors();
        }

        $model = new People($request->all());
        if ($model->save()) {
            return (new PeopleResource($model))
                ->response()
                ->setStatusCode(201);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/people/{id}",
     *     @OA\Response(
     *          response="200",
     *          description="Update People",
     *          @OA\JsonContent(ref="#/components/schemas/PeopleUpdate")
     *     ),
     *     tags={"People"},
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PeopleUpdate")
     *      )
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $this->valid($request, ['id' => 'required', 'name' => 'required']);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if (is_numeric($id)) {
            $model = People::find($id);
            if ($model) {
                $model->fill($request->all());
                $model->save();
                return (new PeopleResource($model))
                    ->response()
                    ->setStatusCode(200);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/people/{id}",
     *     @OA\Response(
     *          response="200",
     *          description="Delete People By id",
     *          @OA\JsonContent(ref="#/components/schemas/DestroyResource")
     *     ),
     *     tags={"People"},
     *     security={{"apiAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * )
     */
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
