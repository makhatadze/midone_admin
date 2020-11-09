<?php

namespace App\Http\Controllers\Backend;

use App\Models\Approve;
use App\Models\Category;
use App\Models\Department;
use App\Models\Message;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class TicketsController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View|Application|Factory|View
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();

        $departments = Department::all();

        $categories = [];

        if (count($departments) > 0) {
            $categories = $departments[0]->categories()->get();
        }


        return view('backend.module.tickets.index', [
            'tickets' => $tickets,
            'departments' => $departments,
            'categories' => $categories
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Department $department
     *
     * @return array
     */
    public function departments(Request $request, Department $department)
    {
        if ($request->ajax()) {
            return Category::where('department_id', $department->id)->get()->toArray();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return bool|Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
//        validate the fields
        $request->validate([
            'ticket_department' => 'required|integer',
            'ticket_category' => 'integer|nullable',
            'ticket_name' => 'string|max:255|nullable',
            'ticket_message' => 'required|string',
            'ticket_level' => 'required'
        ]);

        if (!$request->_token) {
            return true;
        }


        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:pdf,xlx,text,csv,jpeg,png,bmp,gif,svg,webp'
            ]);
        }

        $ticket = new Ticket();
        $ticket->user_id = auth()->user()->id;
        $ticket->department_id = $request->ticket_department;
        $ticket->name = $request->ticket_name;
        $ticket->level = $request->ticket_level;
        if ($request->ticket_category != null && $request->ticket_category != '0') {
            $ticket->category_id = $request->ticket_category;
            $category = Category::where('id', $request->ticket_category)->first();

            $ticket->name = $category->name;
        }
        if ($request->ticket_deadline != null) {
            $deadline = $request->ticket_deadline . ' ' . $request->ticket_deadline_time;
            $ticket->deadline = Carbon::parse($deadline);
        }

        $ticket->save();

        $message = new Message();
        $message->body = $request->ticket_message;
        $message->user_id = auth()->user()->id;
        $message->answer = false;
        $ticket->message()->save($message);

        if ($request->hasFile('file')) {
            $fileName = date('Ymhs') . $request->file('file')->getClientOriginalName();
            $destination = base_path() . '/storage/app/public/tickets/' . $message->id;
            $request->file('file')->move($destination, $fileName);
            $message->file()->create([
                'name' => $fileName
            ]);
        }

        return redirect('/admin/tickets')->with('success', 'Ticket successfully created!');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View|Application|Factory|View
     */
    public function getAllTickets()
    {
        $authUser = auth()->user();
        return view('backend.module.tickets.tickets', [
            'tickets' => $authUser->getTickets(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Ticket $ticket
     *
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|Redirector
     */
    public function ticketApprove(Request $request, Ticket $ticket)
    {
        $request->validate([
            'department' => 'required|integer',
            'approve' => 'integer|nullable'
        ]);

        $approve = new Approve();
        $approve->ticket_id = $ticket->id;
        $approve->department_id = $request->department;
        $approve->user_id = auth()->user()->id;
        $message = 'Ticket approved successfully';

        if ($request->approve == null) {
            $approve->status = false;
            $message = 'Ticket rejected successfully';
        }

        $approve->save();

        return redirect('/admin/tickets-all')->with('success', $message);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Ticket $ticket
     *
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|Redirector
     */
    public function ticketConfirm(Ticket $ticket)
    {

        if ($ticket && auth()->user()->canConfirm($ticket)) {
            $ticket->confirm = auth()->user()->name;
            $ticket->closed_at = Carbon::now()->toDateTimeString();
            $ticket->save();
            return redirect('/admin/tickets-all')->with('success', 'Ticket successfully confirmed');

        }

        return redirect('/admin/tickets-all')->with('danger', 'Something wrong, Ticket not confirmed.');


    }


    protected function confirm($department)
    {

    }
}
