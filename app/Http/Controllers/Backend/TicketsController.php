<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ticket;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketsController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View|Application|Factory|View
     */
    public function index()
    {
        $tickets = Ticket::all();

        return view('backend.module.tickets.index', [
            'tickets' => $tickets,
        ]);
    }
}
