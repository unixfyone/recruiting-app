<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Experience extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'position'        => $this->position,
            'company_name'    => $this->company_name,
            'functions'       => $this->functions,
            'currently'       => $this->currently,
            'date_from'       => $this->date_from,
            'date_to'         => $this->date_to,
            'diff'            => Carbon::parse($this->date_from)->diff(Carbon::parse($this->date_to))->format('%y años, %m mes, %d dias'),
            'reference_name'  => $this->reference_name,
            'reference_phone' => $this->reference_phone
        ];
    }
}
