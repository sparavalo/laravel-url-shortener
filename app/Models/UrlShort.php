<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
    use HasFactory;

    protected $table = 'url_shortener';
    protected $primaryKey = 'id';

    protected $fillable = [
        'redirect_url',
        'slug',
    ];
}
