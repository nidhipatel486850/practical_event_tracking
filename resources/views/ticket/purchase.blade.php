@extends('layouts.main')
@section('title') Dashboard @endsection
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Event : {{$event->title}}</h3>
                    <div class="pricing-table">
                        <!-- Basic Plan -->
                        <div class="pricing-plan">
                            <div class="plan-title">Early bird</div>
                            <div class="plan-price">$10</div>
                            <a href="{{ route('ticket.checkout',['event' => $event->id, 'plan' => 10]) }}" class="sign-up-btn">Buy</a>
                        </div>

                        <!-- Standard Plan -->
                        <div class="pricing-plan">
                            <div class="plan-title">Regular</div>
                            <div class="plan-price">$20</div>
                            <a href="{{ route('ticket.checkout',['event' => $event->id, 'plan' => 20]) }}" class="sign-up-btn">Buy</a>
                        </div>

                        <!-- Premium Plan -->
                        <div class="pricing-plan">
                            <div class="plan-title">VIP</div>
                            <div class="plan-price">$30</div>
                            <a href="{{ route('ticket.checkout',['event' => $event->id, 'plan' => 30]) }}" class="sign-up-btn">Buy</a>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
@endsection

