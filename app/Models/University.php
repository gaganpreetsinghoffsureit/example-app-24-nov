<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'zip_code',
        'city',
        'state',
        'country',
        'verified_at',
    ];

    protected $hidden = [
        'deleted_at',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
