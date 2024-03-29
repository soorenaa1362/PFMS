<?php

namespace App\Models;

use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cards';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'alias',
        'date',
        'number',
        'current_cash',
        'description'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
