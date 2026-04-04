<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

    public function tutorias()
    {
        return $this->hasMany(Tutoria::class, 'tutor_id');
    }
}
