<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->toDateTimeString(),
            'title' => $this->title,
            'description' => $this->description,
            'start' => $this->start->toDateTimeString(),
            'end' => $this->end->toDateTimeString(),
            'organizers' => PersonResource::collection($this->whenLoaded('organizers')),
        ];
    }
}
