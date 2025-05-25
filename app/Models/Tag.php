<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = [
        'id',
        'tag_name'
    ];

    public function rateResults()
    {
        return $this->belongsToMany(RateResult::class, 'rate_result_tag');
    }
}
