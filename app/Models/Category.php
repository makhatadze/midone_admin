<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'status'];
    protected $table = 'categories';


    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_categories');
    }
}
