<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $table = 'costs';

    protected $fillable = [
        'user_id',
        'card_id',
        'category_id',
        'title',
        'amount',
        'date',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'category_id');
    }
}
