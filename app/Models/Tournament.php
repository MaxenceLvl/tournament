<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
