<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);


         return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,

            'protocol_id' => $this->protocol_id,
            'status_id' => $this->status_id,

            'description' => $this->description,
            'config' => $this->config,

            'created_at' => $this->created_at,
        ];
    }
}
