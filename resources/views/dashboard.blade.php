@extends('layouts.main')
@section('title') Dashboard @endsection
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-4">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <h4 class="card-title card-title-dash">Upcoming events</h4>
                                      <div class="add-items d-flex mb-0">
                                        <a href="{{ route('event.create')}}" class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></a>
                                      </div>
                                    </div>
                                    <div class="list-wrapper">
                                        @if($data['upcomingEvents']->isEmpty())
                                            <p>No upcoming events.</p>
                                        @else
                                        <ul class="todo-list todo-list-rounded">
                                            @foreach($data['upcomingEvents'] as $event)
                                            <li class="d-block">
                                                <div class="form-check w-100">
                                                    <label class="form-check-label">
                                                    <input class="checkbox" type="checkbox"> {{ $event->title }} <i class="input-helper rounded"></i>
                                                    </label>
                                                    <div class="d-flex mt-2">
                                                    <div class="ps-4 text-small me-3">{{ date('F j, Y',strtotime($event->event_date)) }}</div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3>Tickets Sold</h3>
                            <canvas id="ticketsSoldChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h3>Total Revenue</h3>
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
@endsection
@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ticketsSoldCtx = document.getElementById('ticketsSoldChart').getContext('2d');
    const ticketsSoldChart = new Chart(ticketsSoldCtx, {
        type: 'bar',
        data: {
            labels: @json($data['eventNames']),
            datasets: [{
                label: 'Tickets Sold',
                data: @json($data['ticketsSoldData']),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($data['eventNames']),
            datasets: [{
                label: 'Total Revenue ($)',
                data: @json($data['revenueData']),
                backgroundColor: 'rgba(75, 192, 192, 0.4)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
