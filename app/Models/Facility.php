<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'latitude',
        'longitude',
        'address',
        'description'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function getTypeLabelAttribute()
    {
        $labels = [
            'sekolah' => 'Sekolah',
            'rumah_sakit' => 'Rumah Sakit',
            'puskesmas' => 'Puskesmas',
            'tempat_ibadah' => 'Tempat Ibadah',
            'pasar' => 'Pasar',
            'lainnya' => 'Lainnya'
        ];
        
        return $labels[$this->type] ?? $this->type;
    }
}