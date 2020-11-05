<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];
    protected $table = 'departments';

    /**
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_departments');
    }

    public function head()
    {
        return $this->belongsToMany(User::class, 'department_heads');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'department_categories');
    }
}
