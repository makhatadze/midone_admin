<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body'
    ];
    protected $table = 'messages';

    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the message's file.
     */
    public function file()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }
}
