<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = [
            "id" => $this->id,
            "name" => $this->name,
            "phone" => $this->phone,
            "date_of_birth" => $this->date_of_birth,
            "gender" => $this->gender,
            "role" => $this->role->position,
            "address" => $this->address,
            "banned" => $this->banned,
            "email" => $this->email,
            "photo" => $this->photo,
            "created_at" => $this->created_at->format('d M Y')
        ];
        return $user;
    }
}
