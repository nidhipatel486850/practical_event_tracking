<?php
namespace App\Repositories;

use App\Models\Event;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\TicketSale;
use App\Mail\TicketConfirmationMail;
use Illuminate\Support\Facades\Mail;

class TicketRepositories
{
    private Event $model;

    private Comment $commentModel;

    /**
     * TicketRepositories constructor.
     *
     * @param Event $event
     */
    public function __construct(Event $event, Comment $comment)
    {
        $this->model = $event;
        $this->commentModel = $comment;
    }
    public function index($request)
    {
        $query = $this->model->select('*')
            ->where('status',1)
            ->orderBy('created_at','desc');

        return Datatables::of($query)->addIndexColumn()
            ->addColumn('action', function($row){
                //   $btn .= '<a onClick="javascript:void(0)" data-route="'.route('company.destroy',$row->id).'" class="btn btn-primary btn-sm itemDelete" title="Remove"><i class="fa fa-trash"></i></a> ';
                return "<a href=".route('ticket.view',$row->id)." class='btn btn-primary'> <i class='fa fa-eye'></i> </a>";
            })
            ->editColumn('status', function ($row) {
                if($row->status){
                    $status = 'checked';
                }else{
                    $status = '';
                }
                return '<label class="switch">
                                <input type="checkbox" id="is_active" name="is_cancel" '.$status.' class="changeStatus" data-route="'.route('event.cancel',$row->id).'">
                                <span class="slider round"></span>
                            </label>';
            })
            ->rawColumns(['action','status'])
            ->make();
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

    public function checkout($event,$plan){
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $event->title,
                    ],
                    'unit_amount' => $plan*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'event_id' => $event->id,
            ],
            'success_url' =>  url('/tickets/checkout/success/{CHECKOUT_SESSION_ID}'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return Redirect::to($session->url);

    }

    public function success($session_id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($session_id);
        if($session->payment_status == 'paid'){
            $user=Auth::user();
            $event = Event::find($session->metadata->event_id);
            $ticketSale = new TicketSale();
            $ticketSale->event_id=$event->id;
            $ticketSale->user_id=$user->id;
            $ticketSale->ticket_type=$session->amount_total/1000;
            $ticketSale->price=$session->amount_total/100;
            if($ticketSale->save()){
                try{
                    Mail::to($user->email)->send(new TicketConfirmationMail($user->email, $event->title));
                } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {}

                return true;
            }
        }
        return false;
    }

    public function saveComment($request): bool
    {
        $user=Auth::user();
        $comment=new Comment();
        $comment->event_id=$request->event_id;
        $comment->user_id=$user->id;
        $comment->comments=$request->comment;
        if($comment->save()){
            return true;
        }else{
            return false;
        }
    }

    public function getCommentList($request,$event)
    {
        $query = $this->commentModel->select('comments.*')
            ->where('event_id',$event->id)
            ->orderBy('created_at','desc');

        return Datatables::of($query)->addIndexColumn()
            ->editColumn('created_at', function($row){
                 return date('d-m-Y',strtotime($row->created_at));
            })
            ->rawColumns(['created_at'])
            ->make();
    }

}
