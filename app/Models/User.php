<?php
/**
 *  app/Models/User.php
 *
 * User:
 * Date-Time: 06.11.20
 * Time: 13:34
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Profile
    public function profile()
    {
        return $this->morphOne('App\Models\Profile', 'profileable');
    }


    /**
     *
     * @return mixed
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments');
    }

    /**
     *
     * @return mixed
     */
    public function departmentsHead()
    {
        return $this->belongsToMany(Department::class, 'department_heads');
    }

    public function getTickets($owner = false)
    {
        $tickets = $owner ? Ticket::where('user_id', $this->id)->get() : Ticket::get();
        $data = [];
        foreach ($tickets as $ticket) {
            if ($this->canAccessTicket($ticket)) {
                $data [] = [
                    'id' => $ticket->id,
                    'user' => User::getName($ticket->user_id),
                    'department' => Department::getName($ticket->department_id),
                    'name' => $ticket->name,
                    'deadline' => $ticket->deadline,
                    'level' => $ticket->getTicketLevelName(),
                    'confirm' => $ticket->confirm,
                    'process' => $ticket->process,
                    'approve_departments' => $ticket->getApproveDepartments(),
                    'closed_at' => $ticket->closed_at,
                    'created_at' => Carbon::createFromTimestamp($ticket->created_at),
                    'can_approve' => $this->canApprove($ticket),
                    'can_confirm' => $this->canConfirm($ticket)
                ];
            }
        }

        return array_reverse($data);

    }

    public function getNotificationTicketCreated(Ticket $ticket): array
    {
        if (!$this->canAccessTicket($ticket)) {
            abort(404);

        }
        if ($ticket->user_id === $this->id) {
            abort(404);

        }
        return [
            'message' => 'New Ticket Created',
        ];
    }

    public static function getName($id)
    {
        $user = User::find($id);
        return $user ? $user->name : 'User deleted';
    }

    protected function canAccessTicket($ticket)
    {
        if ($this->hasRole('admin')) {
            return true;
        }
        $department = Department::find($ticket->department_id);
        if ($department != null) {
            $heads = $department->head()->get()->toArray();
            $users = $department->users()->get()->toArray();
            if (count($heads) > 0 && in_array($this->id, array_column($heads, 'id'))) {
                return true;
            }
            if (count($users) > 0 && in_array($this->id, array_column($users, 'id'))) {
                return true;
            }
        }
        if ($ticket->category_id) {
            $categories = Category::find($ticket->category);
            if ($categories != null) {
                $departments = $categories->departments()->get()->toArray();
                if (count($departments) > 0) {
                    foreach ($departments as $dep) {
                        $staff = $dep->users()->get()->toArray();
                        if (count($staff) > 0 && in_array($this->id, array_column($staff, 'id'))) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    protected function canApprove($ticket)
    {
        $departments = ($this->departmentsHead()->get() != null) ? $this->departmentsHead()->get() : $this->departments()->get();
        $departmentID [] = ['id' => $ticket->department_id];
        if ($ticket->category_id) {
            $category = Category::find($ticket->category_id);
            if ($category != null) {
                $departmentGroups = $category->departments()->select('id')->get()->toArray();
                $departmentGroups [] = $departmentID[0];
                $departmentID = $departmentGroups;
            }
        }
        $data = [];

        if (count($departmentID) > 0) {
            foreach ($departmentID as $dep) {
                $approveDepartments = $ticket->getApproveDepartments();
                $index = array_search($dep['id'], array_column($approveDepartments, 'department_id'));
                $heads = $this->departmentsHead()->get()->toArray();
                $staff = $this->departments()->get()->toArray();
                if (is_int($index) && $approveDepartments[$index]['approved'] == false) {
                    if (!$this->hasRole('admin')) {
                        if (!in_array($approveDepartments[$index]['department_id'], array_column($heads, 'id')) &&
                            !in_array($approveDepartments[$index]['department_id'], array_column($staff, 'id'))) {
                            continue;
                        }
                    }
                    $data [] = [
                        'approved' => $approveDepartments[$index]['approved'],
                        'department_name' => $approveDepartments[$index]['department'],
                        'department_id' => $approveDepartments[$index]['department_id']
                    ];
                }
            }
        }

        return $data;
    }

    public function canConfirm($ticket)
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        if ($this->id === $ticket->user_id) {
            return true;
        }
        return false;
    }


}
