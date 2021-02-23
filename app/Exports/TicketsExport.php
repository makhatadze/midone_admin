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
FromQuery, ShouldAutoSize, WithEvents, WithHeadings, WithMapping {

    use Exportable;

    private $fileName = 'tickets.xlsx';

    private $ticketIds  = [];
    
    public function query() 
    {
        
        $ticketIds = $this->getTicketIds();
        
        $tickets = Ticket::query()->WhereIn('id',$ticketIds);
        
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
            $ticket->department->name,
            $ticketLevels[$ticket->level],
            $ticket->deadline,
            $ticket->user->username,
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
}
