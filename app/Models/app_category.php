<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class app_category extends Model
{
    use HasFactory;
    public function Apps_category()
    {
        return $this->belongsToMany(app_category::class,'user_id');
    }
}
