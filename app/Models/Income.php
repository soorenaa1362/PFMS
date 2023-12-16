<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'incomes';

    protected $dates = ['deleted_at'];

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
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }


    public function getDateJalali()
    {
        if (!is_null($this->date))
            return Jalalian::fromDateTime($this->date)->format('Y/m/d');
        return null;
    }


    public function getDateTimestamp()
    {
        if (!is_null($this->date))
            return Jalalian::fromDateTime($this->date)->getTimestamp();
        return null;
    }
}
