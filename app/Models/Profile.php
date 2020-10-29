<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    
    // File
    public function profile()
    {
        return $this->morphOne('App\Model\File', 'fileable');
    }
    public function profileable()
    {
        return $this->morphTo();
    }
}
