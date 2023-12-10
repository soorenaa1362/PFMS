<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $fillable = [
        'user_id',
        'name',
        'alias',
        'number',
        'current_cash',
        'description'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
