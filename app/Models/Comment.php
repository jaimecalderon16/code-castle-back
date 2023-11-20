<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['comment', 'comment_date', 'user_id', 'app_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function app()
    {
        return $this->belongsTo(apps::class,'app_id');
    }
}
