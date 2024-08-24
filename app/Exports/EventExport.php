<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class EventExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function query()
    {
        return Event::select('events.*')
            ->where('user_id',Auth::user()->id)
            ->orderBy('events.created_at', 'desc');
    }
    /**
     * @param User $user
     */
    public function map($event): array
    {
        return [
            $event->title,
            $event->description,
            date('d-m-Y',strtotime($event->event_date)),
            $event->location,
            $event->status?'Active':'Cancelled',
            $event->total_tickets,
            $event->availableTickets(),
            $event->soldTickets()
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Event date',
            'Location',
            'Status',
            'Total tickets',
            'Available Tickets',
            'Sold Tickets'
        ];
    }
}
