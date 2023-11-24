<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    protected $fillable = [
        'name',
        'verified_at',
        'semester_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];


   
}
