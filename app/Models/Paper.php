<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Paper extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "user_id",
        "date",
        "subject_id",
        "images",
        "pdf",
        "verified_at",
        "verified_id",
    ];

    protected $hidden = [
        'deleted_at',
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);

    }

    protected function images(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => is_array($value) ? json_encode($value):$value,
            get: fn ($value) => json_decode($value),
        );
    }

}
