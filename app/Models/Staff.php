<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';
    protected $fillable = ['uuid', 'name', 'email', 'image', 'position_id', 'id_number', 'sex', 'phone'];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function rateResults()
    {
        return $this->hasMany(RateResult::class, 'staff_id');
    }

    public function rateResultTags()
    {
        return $this->hasMany(RateResultTag::class, 'staff_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'rate_result_tag', 'staff_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'staff_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
