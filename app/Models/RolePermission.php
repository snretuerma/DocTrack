<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    public $timestamp = false;

    protected $guarded = [
        'name'
    ];


    public function permission() {
        return $this->hasOne('App\Models\Permission');
    }

    public function role() {
        return $this->hasOne('App\Models\Role');
    }
}
