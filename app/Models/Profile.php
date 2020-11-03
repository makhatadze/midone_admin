<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'phone',
        'country'
    ];

    // File
    public function profile()
    {
        return $this->morphOne('App\Models\File', 'fileable');
    }

    /**
     * Get the owning profileable model.
     */
    public function profileable()
    {
        return $this->morphTo();
    }
}
