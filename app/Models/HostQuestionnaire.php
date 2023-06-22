<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HostQuestionnaire extends Model
{
    use HasFactory;
    protected $table = 'host_questionnaires';
    protected $fillable = ['question','answer_type','host_id','checkbox_name'];
}
