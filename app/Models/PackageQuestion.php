<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'package_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (self::where('question_id', $model->question_id)->exists()) {
                throw new \Exception('Soal ini sudah terdaftar dalam paket lain.');
            }
        });
    }


    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
