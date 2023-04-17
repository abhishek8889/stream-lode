<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostNotification extends Model
{
    use HasFactory;
    protected $table = 'post_notifications';
    protected $fillable = [
        'sender_id','message','reciever_id','username','seen_users'
    ];
}
