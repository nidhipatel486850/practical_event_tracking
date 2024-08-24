<?php
namespace App\Repositories;

use App\Models\Event;
use App\Models\TicketSale;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class EventRepositories
{
    private Event $model;

    private TicketSale $ticketModel;

    private Comment $commentModel;

    /**
     * EventRepositories constructor.
     *
     * @param Event $event
     */
    public function __construct(Event $event, TicketSale $ticketSale, Comment $comment)
    {
        $this->model = $event;
        $this->ticketModel= $ticketSale;
        $this->commentModel = $comment;
    }
    public function index($request)
    {
        $query = $this->model->select('*')
            ->where('user_id',Auth::user()->id)
            ->orderBy('created_at','desc');

        return Datatables::of($query)->addIndexColumn()
            ->addColumn('action', function($row){
                 $btn = "<a href=".route('event.show',$row->id)." class='btn btn-info'> <i class='fa fa-eye'></i> </a> ";
                 $btn .="<a href=".route('event.edit',$row->id)." class='btn btn-primary'> <i class='fa fa-edit'></i> </a>";
                 return $btn;
            })
            ->editColumn('status', function ($row) {
                if($row->status){
                    $status = '';
                }else{
                    $status = 'checked';
                }
                return '<label class="switch">
                                <input type="checkbox" id="is_active" name="is_cancel" '.$status.' class="changeStatus" data-route="'.route('event.cancel',$row->id).'">
                                <span class="slider round"></span>
                            </label>';
            })
            ->rawColumns(['action','status'])
            ->make();
    }
    public function save($request): bool
    {
        $user=Auth::user();
        if($request->id){
            $event = Event::find($request->id);
        }else{
            $event = new Event();
        }
        $event->user_id=$user->id;
        $event->title=$request->title;
        $event->description=$request->description;
        $event->event_date=$request->event_date;
        $event->location=$request->location;
        $event->total_tickets=$request->total_tickets;
        if($event->save()){
            return true;
        }else{
            return false;
        }
    }
    public function cancel($request,$event)
    {
        $postData = $request->all();
        if(isset($postData['is_cancel']) && $postData['is_cancel']=="on"){
            $event->status = 0;
        }else{
            $event->status = 1;
        }
        if($event->save()){
            return true;
        }else{
            return false;
        }
    }

    public function getAttendeesList($request,$event)
    {
        $query = $this->ticketModel->select('ticket_sales.*','users.name')
            ->join('users','users.id','=','ticket_sales.user_id')
            ->where('event_id',$event->id)
            ->orderBy('created_at','desc');

        return Datatables::of($query)->addIndexColumn()
            ->editColumn('created_at', function($row){
                 return date('d-m-Y',strtotime($row->created_at));
            })
            ->editColumn('name', function($row){
                return Crypt::decryptString($row->name);
           })
           ->editColumn('price', function($row){
                return '$'.$row->price;
            })
            ->editColumn('ticket_type', function($row){
                switch ($row->ticket_type) {
                    case 1:
                        return 'Early bird';
                        break;
                    case 2:
                        return 'Regular';
                        break;
                    default:
                        return 'VIP';
                        break;
                    }
            })
            ->rawColumns(['created_at'])
            ->make();
    }

    public function getCommentList($request,$event)
    {
        $query = $this->commentModel->select('comments.*','users.name')
            ->join('users','users.id','=','comments.user_id')
            ->where('event_id',$event->id)
            ->orderBy('created_at','desc');

        return Datatables::of($query)->addIndexColumn()
            ->editColumn('created_at', function($row){
                 return date('d-m-Y',strtotime($row->created_at));
            })
            ->editColumn('name', function($row){
                return Crypt::decryptString($row->name);
           })
            ->rawColumns(['created_at'])
            ->make();
    }
}
