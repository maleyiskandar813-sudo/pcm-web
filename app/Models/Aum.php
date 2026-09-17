<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aum';

    public const TYPES = ['pertanian', 'masjid', 'panti', 'lainnya'];

    protected $fillable = [
        'type',
        'name',
        'address',
        'phone',
        'description',
        'maps_url',
        'photo',
    ];
}
