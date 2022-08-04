<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCodes extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'country_codes';

    protected $fillable = [
        'code',
        'country',
        'phone_name',
        'phone_code',
    ];
}
