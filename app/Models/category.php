<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'category';


    public function apps()
    {
        return $this->belongsToMany(apps::class);
    }

}
