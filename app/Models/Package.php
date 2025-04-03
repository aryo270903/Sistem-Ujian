<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'date', 'time','end_time',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(PackageQuestion::class, 'package_id');
    }

    public function getEndTime(): Carbon
{
    return Carbon::parse($this->date . ' ' . $this->time, 'Asia/Jakarta')->addMinutes($this->duration);
}

    
    // Mengecek apakah waktu sudah habis
    public function isExpired(): bool
    {
        return Carbon::now('Asia/Jakarta')->greaterThanOrEqualTo($this->getEndTime());
    }
    

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta');
    }
    
}
