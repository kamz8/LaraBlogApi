<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BadCredentialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'=> 401,
            'message' => 'Invalid credentials.',
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }
}
