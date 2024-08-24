<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Event;
use App\Models\TicketSale;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardRepositories
{
    private User $model;

    /**
     * AuthRepositories constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index($request)
    {
        $events = Event::where('user_id', auth()->id())->get();

        $eventNames = [];
        $ticketsSoldData = [];
        $revenueData = [];

        foreach ($events as $event) {
            $eventNames[] = $event->title;
            $ticketsSoldData[] = TicketSale::where('event_id', $event->id)->count();
            $revenueData[] = TicketSale::where('event_id', $event->id)->sum('price');
        }

        $upcomingEvents = Event::where('event_date', '>', Carbon::now())
                               ->orderBy('event_date')
                               ->take(5)
                               ->get();
        return [
            'eventNames'=>$eventNames,
            'ticketsSoldData'=>$ticketsSoldData,
            'revenueData'=>$revenueData,
            'upcomingEvents'=>$upcomingEvents
        ];
    }

}
