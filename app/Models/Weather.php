<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes; // Jika pakai soft delete

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather';

    protected $fillable = [
        'city',
        'temperature',
        'humidity',
        'description',
        'updated_at'
    ];

    // protected $dates = ['updated_at', 'deleted_at']; // Untuk soft delete
}
