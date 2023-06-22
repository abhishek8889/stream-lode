<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as BaseModel;

class Model extends BaseModel 
{
    protected $connection = "mongodb";
}

