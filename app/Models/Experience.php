<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'position',
        'company_name',
        'functions',
        'currently',
        'date_from',
        'date_to',
        'reference_name',
        'reference_phone'
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
