<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apps extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function apps()
    {
        return $this->hasMany(Comment::class,'app_id','id');
    }

    public function category()
    {
        return $this->belongsToMany(category::class);
    }

}


