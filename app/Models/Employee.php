<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'phone',
        'image',
        'position',
        'division_id',
    ];

    public static function booted() {
        static::creating(function($model) {
            $model->id = Str::uuid();
        });
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
