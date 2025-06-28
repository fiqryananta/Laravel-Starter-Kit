<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'website',
        'logo',
        'created_at',
        'updated_at',
    ];
}
