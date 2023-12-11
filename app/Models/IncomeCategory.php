<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'income_categories';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'parent_id',
        'title',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(IncomeCategory::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(IncomeCategory::class, 'parent_id');
    }
}
