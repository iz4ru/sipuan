<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateResultTag extends Model
{
    protected $table = 'rate_result_tag';
    protected $fillable = ['staff_id', 'rate_result_id', 'tag_id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function rateResults()
    {
        return $this->belongsTo(RateResult::class, 'rate_result_id');
    }

    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
