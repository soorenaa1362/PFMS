<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCategory extends Model
{
    use HasFactory;

    protected $table = 'cost_categories';

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
        return $this->belongsTo(CostCategory::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(CostCategory::class, 'parent_id');
    }
}
