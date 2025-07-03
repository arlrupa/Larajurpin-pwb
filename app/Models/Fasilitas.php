<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Fasilitas extends Model
// {
//     protected $table = 'fasilitas';

//     protected $guarded = [];
// }

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
     use HasFactory;
     protected $table = 'fasilitas';
     protected $fillable = ['name', 'stock', 'condition', 'completeness', 'image'];
}
