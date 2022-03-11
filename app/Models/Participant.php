<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';

    protected $fillable = [
        'id',
        'name',
        'elo',
        'tournamentId'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function tournament()
    {
        return $this->hasOne(Tournament::class, 'tournamentId', 'id');
    }
}
