<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
            set: fn ($value) => is_array($value) ? json_encode(collect(($value))->map(function ($element) {
                return str_replace(URL(""), '', $element);
            })->toArray()):$value,
            get: fn ($value) => collect((json_decode($value)))->map(function ($element) {
                return URL($element);
            })->toArray(),
        );
    }

}
