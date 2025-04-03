<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class OTP extends Model
{
    use HasFactory;

    protected $table = 'otps';
    protected $fillable = ['otp', 'expires_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        // Cek apakah OTP sudah kedaluwarsa berdasarkan WIB
        return Carbon::parse($this->expires_at)->isPast();
    }

    public function getCreatedAtAttribute($value)
    {
        // Mengubah created_at ke zona waktu WIB
        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        // Mengubah updated_at ke zona waktu WIB
        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getExpiresAtAttribute($value)
    {
        // Mengubah expires_at ke zona waktu WIB
        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }
}
