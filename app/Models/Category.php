<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_category', 'name', 'description'
    ];

    protected $guarded = [];


    public function Transaction()
    {
        return $this->belongsTo(Transaction::class, 'id', 'category_id');
    }
}
