<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Education extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'institution' => $this->institution,
            'title'       => $this->title,
            'level'       => $this->level,
            'tesis_title' => $this->tesis_title,
            'currently'   => $this->currently,
            'date_from'   => $this->date_from,
            'date_to'     => $this->date_to
        ];
    }
}
