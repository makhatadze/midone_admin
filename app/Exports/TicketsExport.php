<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;

class TicketsExport implements
      FromQuery, 
      ShouldAutoSize, 
      WithEvents, 
      WithHeadings, 
      WithMapping 
{

    use Exportable;

    private $fileName = 'tickets.xlsx';

    private $ticketIds  = [];
    
    private $withCurrentUser = null;
    
    public function query() 
    {
        
        $tickets = Ticket::query();
        
        $ticketIds = $this->getTicketIds();
        
        if (false === empty($ticketIds)) {
            $tickets->WhereIn('id',$ticketIds);
        }
        
        if (false === is_null($this->withCurrentUser)) {
           $userId = auth()->user()->id;
           ($this->withCurrentUser) ? $tickets->where('user_id','=',$userId) : $tickets->where('user_id','!=',$userId);
        }
        
        return $tickets;
    }

    public function map($ticket): array 
    {
        $ticketLevels = [
            '1' => 'Low',
            '2' => 'Medium',
            '3' => 'High'
        ];
        
        $clientMessageModel = $ticket->message->get(0);
        
        $mapping = [
            $ticket->id,
            $ticket->name,
            ($ticket->department) ? $ticket->department->name : '',
            $ticketLevels[$ticket->level],
            $ticket->deadline,
            ($ticket->user) ? $ticket->user->username : '',
            $clientMessageModel->body,
            $clientMessageModel->created_at->format('l jS \\of F Y h:i:s A')
        ];
        
        return $mapping;
    }

    
    public function headings(): array 
    {
        return [
            'ID','Title','Department','Level','Deadline','Username', 'message','message date'
            
        ];
    }

    public function registerEvents(): array 
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
            $event->sheet->getStyle("A1:H1")->applyFromArray([
                    'font' => [
                        'bold' => 'true'
                    ]
                ]);
            }
        ];
    }
    
    public function setIds ( array $ticketIds) 
    {
       $this->ticketIds = $ticketIds;
       
       return $this;
    }
    
    public function getTicketIds() : array
    {
        return $this->ticketIds;
    }
    
    public function setWithCurrentUser(bool $withUser)
    {
        $this->withCurrentUser = $withUser;
        
        return $this;
    }
}
