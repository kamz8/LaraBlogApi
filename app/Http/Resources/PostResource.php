<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail_url' => $this->thumbnail_url ?? null,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
