<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'explanation',
        'question_image'
    ];

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function getQuestionImageUrlAttribute()
    {
        return $this->question_image ? Storage::url($this->question_image) : null;
    }

}
