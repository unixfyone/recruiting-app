<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'institution',
        'title',
        'level',
        'tesis_title',
        'currently',
        'date_from',
        'date_to'
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
