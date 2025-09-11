<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_report_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
    ];

    public function expenseReport()
    {
        return $this->belongsTo(ExpenseReport::class);
    }
}
