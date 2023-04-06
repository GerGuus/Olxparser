<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ads';
    protected $fillable = [
        'url_id',
        'ad',
    ];

    public function phone(): HasOne
    {
        return $this->hasOne(Url::class);
    }
}
