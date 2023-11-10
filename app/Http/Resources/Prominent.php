<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Prominent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment' => $this->comment,
            'user'    =>  new User($this->user),
            'profile' => new Profile($this->profile),
            'fecha'   => $this->created_at->format('d/m/Y')
        ];
    }
}
