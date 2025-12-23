<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <--- Tambah baris ini

class Product extends Model
{
    use HasFactory, SoftDeletes; // <--- Tambah SoftDeletes di sini

    protected $guarded = [];
}