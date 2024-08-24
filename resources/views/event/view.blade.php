@extends('layouts.main')
@section('title') Event Details @endsection
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Event Details</h4>
                    <p><b>Title :</b> {{ $event->title}}</p>
                    <p><b>Description :</b> {{ $event->description}}</p>
                    <p><b>Event Date :</b> {{ $event->event_date}}</p>
                    <p><b>Location :</b> {{ $event->location}}</p>
                    <p><b>Total Tickets :</b> {{ $event->total_tickets}}</p>
                    <p><b>Available Tickets :</b> {{ $event->availableTickets()}}</p>
                    <p><b>Sold Tickets :</b> {{ $event->soldTickets()}}</p>
                  </div>
                </div>
              </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">Attendees List</h4>
                        <div class="table-responsive">
                            <table class="table" id="datatable_list" aria-label="table">
                            <thead>
                                <tr>
                                <th>User Name</th>
                                <th>Ticket Type</th>
                                <th>Price</th>
                                <th>Purchased Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            </table>
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
                                  <th>User Name</th>
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
                    let columns = [
                        {data: 'name', name: 'name', orderable: false, searchable: false},
                        {data: 'ticket_type', name: 'ticket_type'},
                        {data: 'price', name: 'price'},
                        {data: 'created_at', name: 'created_at'},
                    ];

                    let datatableUrl = "{{ route('event.show',$event->id) }}";
                    let table = showDatatable.show('#datatable_list',datatableUrl,columns)

                    let commentColumns = [
                        {data: 'name', name: 'name', orderable: false, searchable: false},
                        {data: 'comments', name: 'comments'},
                        {data: 'created_at', name: 'created_at'},
                    ];

                    let datatableCommentUrl = "{{ route('event.show',$event->id) }}?getData=comment";
                    let tableComment = showDatatable.show('#comment_list',datatableCommentUrl,commentColumns)
                });
        </script>
@endsection

