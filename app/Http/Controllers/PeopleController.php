<?php

namespace App\Http\Controllers;

use App\Http\Resources\DestroyResource;
use App\Models\People;
use App\Http\Resources\PeopleResource;
use App\Http\Resources\PeopleCollectionResource;
use App\Traits\ValidationMake;
use Illuminate\Http\Request;
use stdClass;

class PeopleController extends Controller
{
    use ValidationMake;

    private $rules = [
        'id' => 'required|numeric',
        'name' => 'required|min:3'
    ];

    /**
     * @OA\Schema(
     *   schema="people",
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
     * @OA\Schema(
     *   schema="peoples",
     *   @OA\Property(
     *       property="data",
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="integer"),
     *           @OA\Property(property="name", type="string")
     *       )
     *    )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/people",
     *     @OA\Response(
     *          response="200",
     *          description="List of People",
     *          @OA\JsonContent(ref="#/components/schemas/peoples")
     *     ),
     *     tags={"People"},
     *     description = "List Of People",
     *     summary="List Of People",
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
     *          description="Show People By Id",
     *          @OA\JsonContent(ref="#/components/schemas/people")
     *     ),
     *     tags={"People"},
     *     description = "Show People By Id",
     *     summary="Show People By Id",
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
        return $this->responseNotFound();
    }

    /**
     * @OA\Post(
     *     path="/api/people",
     *     tags={"People"},
     *     security={{"apiAuth":{}}},
     *     description = "Create People",
     *     summary="Create People",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/people")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Create People",
     *          @OA\JsonContent(ref="#/components/schemas/people")
     *       ),
     *  ),
     * )
     */
    public function create(Request $request)
    {
        $valid = $this->valid($request, $this->rules);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 200);
        }
        $model = new People($request->all());
        if ($model->save()) {
            return (new PeopleResource($model))
                ->response()
                ->setStatusCode(201);
        }
        return $this->responseInternalServerError();
    }

    /**
     * @OA\Put(
     *     path="/api/people/{id}",
     *     description = "Update People",
     *     summary="Update People",
     *     @OA\Response(
     *          response="200",
     *          description="Update People",
     *          @OA\JsonContent(ref="#/components/schemas/people")
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
     *          @OA\JsonContent(ref="#/components/schemas/people")
     *      )
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        $valid = $this->valid($request, $this->rules);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 200);
        }
        $model = People::find($id);
        if ($model) {
            $model->fill($request->all());
            $model->save();
            return (new PeopleResource($model))
                ->response()
                ->setStatusCode(200);
        }
        return $this->responseNotFound();
    }

    /**
     * @OA\Delete(
     *     path="/api/people/{id}",
     *     description = "Delete People By Id",
     *     summary="Delete People By Id",
     *     @OA\Response(
     *          response="202",
     *          description="Delete People By Id",
     *          @OA\JsonContent(ref="#/components/schemas/destroy")
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
    public function delete($id)
    {
        if (is_numeric($id)) {
            $model = People::find($id);
            if ($model) {
                $result = new stdClass;
                $result->deleted = $model->delete();
                $result->found = !is_null($model);
                return (new DestroyResource($result))
                    ->response()
                    ->setStatusCode(202);
            }
            return $this->responseNotFound();
        }
        return $this->responseInternalServerError();
    }
}
