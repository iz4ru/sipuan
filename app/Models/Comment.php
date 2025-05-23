<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'id',
        'staff_id',
        'comment',
    ];
    
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
