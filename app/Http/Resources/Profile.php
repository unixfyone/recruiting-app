<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'full_name'      => $this->first_name.' '.$this->last_name,
            'first_name'     => $this->first_name,
            'last_name'      => $this->last_name,
            'title'          => $this->title,
            'nationality'    => $this->nationality,
            'type_dni'       => $this->type_dni,
            'dni'            => $this->dni,
            'identification' => $this->type_dni.': '.$this->dni,
            'birthdate'      => Carbon::parse($this->birthday)->format('d/m/Y'),
            'gender'         => $this->gender,
            'phone'          => $this->phone,
            'phone2'         => $this->phone2,
            'country_id'     => $this->country_id,
            'state_id'       => $this->state_id,
            'city_id'        => $this->city_id,
            'postal_code'    => $this->postal_code,
            'description'    => $this->description,
            'languages'      => $this->languages,
            'area_interest'  => $this->area_interest,
            'uri_cv'         => $this->uri_cv,
            'status_general' => $this->status_general,
            'user'           => new User($this->user),
            'experiences'    => Experience::collection($this->experiences)
        ];
    }
}
