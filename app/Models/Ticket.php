<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
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

    // Message
    public function message()
    {
        return $this->morphMany('App\Models\Message', 'messageable');
    }

    public function getTicketLevelName()
    {
        if ($this->level == 1)
            return 'Low';
        if ($this->level == 2)
            return 'Medium';
        if ($this->level == 3)
            return 'High';
        return false;
    }

    public function getApproveDepartments()
    {
        $data = [];

        // Get if Main Department approved
        $data[0] = $this->getApproveArray($this->department_id);

        if ($this->category_id) {
            $category = Category::find($this->category_id);
            if (count($category->departments) > 0) {
                foreach ($category->departments as $dep) {
                    $data [] = $this->getApproveArray($dep->id);
                }
            }
        }
        return $data;
    }

    protected function getApproveArray($department_id)
    {
        $approveDepartment = Approve::where([['department_id', $department_id], ['ticket_id', $this->id]])->first();
        if ($approveDepartment != null) {
            return [
                'approved' => true,
                'user' => User::getName($approveDepartment->user_id),
                'department' => Department::getName($approveDepartment->department_id),
                'created_at' => $approveDepartment->created_at,
                'status' => $approveDepartment->status,
                'department_id' => $department_id
            ];
        }
        return [
            'approved' => false,
            'user' => '',
            'department' => Department::getName($department_id),
            'created_at' => '',
            'department_id' => $department_id
        ];
    }

    public function user()
    {
        return $this->hasone('App\Models\User', 'id', 'user_id');

    }
    
    public function scopeClosed($query)
    {
        return $query->whereNotNull('closed_at');
    }
     
     
     public function scopeSuccess($query)
     {
         return $query->where(DB::raw('closed_at'), '<=', DB::raw('deadline'));
     }
     
     public function scopePending($query)
     {
         return $query->whereNull('closed_at');        
     }
}
