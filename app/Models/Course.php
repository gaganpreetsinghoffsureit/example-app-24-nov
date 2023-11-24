<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'verified_at',
        'university_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
