<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['big_title', 'subquestions_answers'];

    protected $casts = [
        'subquestions_answers' => 'array',
    ];
}
