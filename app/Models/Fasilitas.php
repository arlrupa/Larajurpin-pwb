<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
     use HasFactory;
     // protected $table = 'fasilitas';
     protected $fillable = ['name', 'stock', 'condition', 'completeness', 'image'];

     public function bookings()
     {
          return $this->hasMany(Booking::class, 'fasilitas_id');
     }
}
