<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'comment',
        'status',
        'manager_comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(ExpenseDocument::class);
    }
}
