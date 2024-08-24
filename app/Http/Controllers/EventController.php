<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Requests\EventRequest;
use App\Repositories\EventRepositories;
use App\Exports\EventExport;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    /**
     *
     * @return void
    */

     protected EventRepositories $eventRepositories ;
     public function __construct(EventRepositories $eventRepositories)
     {
         $this->eventRepositories  = $eventRepositories;
     }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->eventRepositories->index($request);
        }
        return view('event.index');
    }

    public function create()
    {
        return view('event.form');
    }

    public function store(EventRequest $request)
    {
        $response = $this->eventRepositories->save($request);
        if($response){
            return response()->json([
                'status'=>1,
                'message'=>$request->id?"Event has been updated successfully.":"New event added successfully!!!",
                'redirection_link'=>route('event.index')
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'message'=>"Something Went Wrong, Please try again."
            ]);
        }
    }

    public function edit(Event $event)
    {
        return view('event.form', compact('event'));
    }

    public function show(Event $event,Request $request)
    {
        if ($request->ajax()) {
            if($request->getData == 'comment'){
                return $this->eventRepositories->getCommentList($request,$event);
            }else{
                return $this->eventRepositories->getAttendeesList($request,$event);
            }
        }
        return view('event.view', compact('event'));
    }

    public function cancel(Request $request, Event $event): string
    {
        $success = $this->eventRepositories->cancel($request, $event);
        if($success) {
            $response['status'] = true;
            $response['message'] = "Event status has been updated successfully.";
        } else {
            $response['status'] = false;
            $response['message'] = "Something went wrong, Please try again.";
        }
        return json_encode($response);
    }

    public function export()
    {
        return Excel::download(new EventExport, 'Events_'.time().'.csv');;
    }
}
