<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'nominal', 'description'
    ];

    protected $guarded = [];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
