<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function getIsExpiredAttribute()
    {
        // Jika end_date di masa lalu, maka expired
        return $this->end_date && now()->greaterThan($this->end_date);
    }

    // Accessor untuk cek apakah promo sudah bisa digunakan (sudah masuk tanggal start)
    public function getIsStartedAttribute()
    {
        // Jika start_date <= sekarang, berarti sudah aktif
        return $this->start_date && now()->greaterThanOrEqualTo($this->start_date);
    }
    public function orders()
    {
        // hasMany karena satu promo bisa dipakai di banyak order
        return $this->hasMany(Order::class, 'promo_id', 'id');
    }
}
