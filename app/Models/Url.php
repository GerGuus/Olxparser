<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'url';
    protected $fillable = [
        'user_id',
        'url',
    ];

    public function phone(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
