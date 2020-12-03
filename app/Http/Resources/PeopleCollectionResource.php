<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PeopleCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}
