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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'scope_id' => $this->scope_id,
            'role_id' => $this->role_id,
            'role' => new RoleResource($this->whenLoaded('role')),
            'token' => $this->when(isset($this->token), $this->token),
        ];
    }
}
