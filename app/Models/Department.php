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

    public static function getName($id)
    {
        $department = Department::find($id);
        return $department ? $department->name : 'Department deleted';
    }

    public static function getUserEmails($id, $data = [])
    {
        $department = Department::find($id);

        $heads = $department->head()->select('email')->get()->toArray();
        if (count($heads) > 0) {
            foreach ($heads as $head) {
                if (in_array($head['email'], $data)) {
                    continue;
                }
                $data [] = $head['email'];
            }
        }

        $staffs = $department->users()->select('email')->get()->toArray();
        if (count($staffs) > 0) {
            foreach ($staffs as $staff) {
                if (in_array($staff['email'], $data)) {
                    continue;
                }
                $data [] = $staff['email'];
            }
        }

        return $data;
    }
}
