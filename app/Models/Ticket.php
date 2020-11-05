<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'category_id',
        'name',
        'level',
        'deadline',
        'confirm',
        'process',
        'closed_at',
    ];
    protected $table = 'tickets';

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }
}
