@extends('layouts.main')
@section('title') Events List @endsection
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 mb-2" style="text-align: end;">
                    <div class="justify-content-between align-items-center">
                        <a href="{{ route('event.export') }}" class="btn btn-info"><i class="fa fa-download"></i> Export</a>
                        <a class="btn btn-primary" href="{{route('event.create')}}">
                            Add New Event
                        </a>
                    </div>
                </div>
            </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Events List</h4>
                  <div class="table-responsive">
                    <table class="table" id="datatable_list" aria-label="table">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Event Date</th>
                          <th>location</th>
                          <th>Total Tickets</th>
                          <th>Cancelled</th>
                          <th>Action</th>
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
@endsection
@section('page-script')
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"
            integrity="sha384-xALJq8UYpj077JDSWSX1xCn84GXeoqSVqRqoVQKZBtsXHnkUq6yl/3leZHBZZZ8c"
            crossorigin="anonymous"></script>
            <script type="text/javascript">
                $(function () {
                    let columns = [
                        {data: 'title', name: 'title', orderable: false, searchable: false},
                        {data: 'description', name: 'description'},
                        {data: 'event_date', name: 'event_date'},
                        {data: 'location', name: 'location'},
                        {data: 'total_tickets', name: 'total_tickets'},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ];

                    let datatableUrl = "{{ route('event.index') }}";
                    let table = showDatatable.show('#datatable_list',datatableUrl,columns)


            $(document).on('change', '.changeStatus', function(){

                let url = $(this).data("route");
                let check='off';
                if($(this).is(":checked")){
                    check='on'
                }

                const formData = {
                    '_token': '{{ csrf_token() }}',
                    'is_cancel':check
                };
                ajaxCall('POST',url,formData);
                table.ajax.reload(null, false);
            });
        });
            </script>
@endsection
