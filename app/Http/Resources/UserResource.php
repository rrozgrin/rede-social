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
                "id" => $this -> id,
                "name" => $this -> name,
                "email" => $this -> email,
                "email_verified_at" => $this -> email_verified_at,
                "username" => $this -> username,
                "created_at" => $this -> created_at,
                "updated_at" => $this -> updated_at,
                "cover_url" => $this -> cover_path,
                "avatar_url" => $this -> avatar_path,
        ];
    }
}
