<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DestroyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'found' => $this->deleted,
            'deleted' => $this->deleted
        ];
    }

    public function withResponse($request, $response)
    {
        //$response->setStatusCode(204);
    }
}
