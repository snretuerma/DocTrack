<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action', 'item_id',
        'table_name', 'original_values', 'new_values'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
