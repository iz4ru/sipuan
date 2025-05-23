<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RateResult extends Model
{
    use HasFactory;
    protected $table = 'rate_results';
    protected $fillable = [
        'id',
        'staff_id',
        'position_id',
        'comment_id',
        'rate',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
