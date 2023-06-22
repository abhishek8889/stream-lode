<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tags extends Model
{
    use HasFactory;
    protected $table = "tags";
    protected $fillable = [
        'user_id','name'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
