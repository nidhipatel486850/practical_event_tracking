<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Repositories\TicketRepositories;
use App\Http\Requests\CommentRequest;

class TicketController extends Controller
{
    /**
     *
     * @return void
    */

     protected TicketRepositories $ticketRepositories ;
     public function __construct(TicketRepositories $ticketRepositories)
     {
         $this->ticketRepositories  = $ticketRepositories;
     }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketRepositories->index($request);
        }
        return view('ticket.index');
    }

    public function view(Event $event,Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketRepositories->getCommentList($request,$event);
        }
        return view('ticket.view', compact('event'));
    }

    public function purchase(Event $event)
    {
        return view('ticket.purchase', compact('event'));
    }

    public function checkout(Event $event,$plan){
        return $this->ticketRepositories->checkout($event,$plan);
    }

    public function success($session_id)
    {
        $success = $this->ticketRepositories->success($session_id);
        if($success){
            return view('ticket.success');
        }else{
            return view('ticket.cancel');
        }
    }
    public function cancel()
    {
        return view('ticket.cancel');
    }

    public function saveComment(CommentRequest $request){
        $response = $this->ticketRepositories->saveComment($request);
        if($response){
            return response()->json([
                'status'=>1,
                'message'=>"Comment has been updated successfully.",
                'redirection_link'=>route('ticket.view',$request->event_id)
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'message'=>"Something Went Wrong, Please try again."
            ]);
        }
    }
}
