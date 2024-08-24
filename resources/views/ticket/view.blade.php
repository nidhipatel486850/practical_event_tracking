@extends('layouts.main')
@section('title') Dashboard @endsection
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Event Details</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Title :</b> {{ $event->title}}</p>
                            <p><b>Description :</b> {{ $event->description}}</p>
                            <p><b>Event Date :</b> {{ $event->event_date}}</p>
                            <p><b>Location :</b> {{ $event->location}}</p>
                            <p><b>Total Tickets :</b> {{ $event->total_tickets}}</p>
                            <p><b>Available Tickets :</b> {{ $event->availableTickets()}}</p>
                            <p><b>Sold Tickets :</b> {{ $event->soldTickets()}}</p>
                            @if($event->availableTickets())
                                <a href="{{ route('ticket.purchase',$event->id) }}" class="btn btn-primary me-2">Purchase Ticket</a>
                            @else
                                <p style="color: red">All tickets are sold out.</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Add Comments</h5>
                            <form class="forms-sample" method="post" id="addComment" onsubmit="submitForm(this);" action="{{ route('ticket.comment',$event->id) }}">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                              <div class="form-group">
                                <textarea class="form-control" name="comment"></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary me-2">Submit</button>
                            </form>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Comments List</h4>
                      <div class="table-responsive">
                        <table class="table" id="comment_list" aria-label="table">
                          <thead>
                            <tr>
                              <th>Comments</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>
        </div>
@endsection
@section('page-script')
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"
            integrity="sha384-xALJq8UYpj077JDSWSX1xCn84GXeoqSVqRqoVQKZBtsXHnkUq6yl/3leZHBZZZ8c"
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function () {
            let commentColumns = [
                {data: 'comments', name: 'comments'},
                {data: 'created_at', name: 'created_at'},
            ];

            let datatableCommentUrl = "{{ route('ticket.view',$event->id) }}";
            let tableComment = showDatatable.show('#comment_list',datatableCommentUrl,commentColumns)
        });
    </script>
@endsection

