@extends('layouts.main')
@section('title') Create Event @endsection
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">{{ @$event?'Update':'Create'}} Event</h4>
                    <form class="forms-sample" id="createEvent" onsubmit="submitForm(this);" action="{{ route('event.store') }}">
                        @csrf
                        @if(@$event)
                            <input type="hidden" name="id" value="{{$event->id}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" value="{{@$event->title?$event->title:''}}" name='title' id="title" placeholder="Title">
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name='description' id="description">{{@$event->description?$event->description:''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" class="form-control" value="{{@$event->event_date?\Carbon\Carbon::parse($event->event_date)->format('Y-m-d'):''}}" name='event_date' id="event_date" placeholder="Event Date">
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" value="{{@$event->location?$event->location:''}}" name='location' id="location" placeholder="Location">
                                  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_tickets">Total Tickets</label>
                                    <input type="number" class="form-control" value="{{@$event->total_tickets?$event->total_tickets:''}}" name='total_tickets' id="total_tickets" placeholder="Total tickets">
                                  </div>
                            </div>
                        </div>
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="{{route('event.index')}}" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
@endsection
