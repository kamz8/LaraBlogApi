<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
//            show additional user information for allowed user
            $this->mergeWhen(!is_null($request->user()) && $request->user()->isAllowed(), [
                'role_id' => $this->role_id,
                'role' => new RoleResource($this->whenLoaded('role')),
                'email' => $this->email,
                'email_verified_at' => $this->email_verified_at,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]),
            'name' => $this->name,


        ];
    }
}
