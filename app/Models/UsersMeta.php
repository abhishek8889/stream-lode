<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Auth\UsersMeta as Authenticatable;

class UsersMeta extends Model
{
    use HasFactory;
    protected $table = "users_meta";
}
