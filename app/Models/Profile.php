<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'title',
        'nationality',
        'type_dni',
        'dni',
        'birthdate',
        'gender',
        'phone',
        'phone2',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'description',
        'languages',
        'area_interest',
        'uri_cv',
        'status_general',
        'status'
    ];

    //Relationship
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function educations(){
        return $this->hasMany(Education::class);
    }

    public function experiences(){
        return $this->hasMany(Experience::class)->orderBy('id','desc')->limit(1);
    }

    //Query Scope
    public function scopeStatusGeneral($query, $status_general) {
        if($status_general !== 'null')
            return $query->where('status_general', $status_general);
    }

    public function scopeAreaInterest($query, $area_interest) {
        if($area_interest !== 'null')
            return $query->whereRaw("JSON_CONTAINS(area_interest, '$area_interest')");
    }

}
