<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmToken extends Model
{
    protected $table = 'email_verify_tokens';

    protected $fillable = [
        'email',
        'token',
        'expired_at',
        'created_at',
        'updated_at',
    ];
}
