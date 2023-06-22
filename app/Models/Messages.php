<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'sender_id','reciever_id','username','message','type','status'
    ];
    public function users(){
        return $this->belongsTo(User::class,'sender_id');
    }
    // public function message(){
    //     return $this->hasMany()
    // }
    public function user(){
        return $this->belongsTo(User::class,'_id','sender_id');
    }
}
