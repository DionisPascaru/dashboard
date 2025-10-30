<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const DQL_ALIAS = 'clients';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'createdAt',
        'updatedAt',
    ];
}
