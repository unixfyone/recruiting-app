<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prominent extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'user_id',
        'comment'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
