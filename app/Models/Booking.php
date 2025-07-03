<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Fasilitas;


class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'nama_lengkap',
    'email',
    'no_telp',
    'instansi',
    'activity_description',
    'fasilitas_id',
    'unit_amount',
    'start_date',
    'end_date',
    'start_time',
    'end_time',
];


    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
}
}