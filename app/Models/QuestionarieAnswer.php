<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionarieAnswer extends Model
{
    use HasFactory;
    protected $table = 'questionarie_answers';
    protected $fillable = [
        'questions','answers','appointment_id',
    ];
}
