@extends('layouts.auth')
@section('title') Register @endsection
@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{asset('images/logo.svg')}}" alt="logo">
              </div>
              <h4>New here?</h4>
              <h6 class="fw-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" id="registerForm" onsubmit="submitForm(this);" action="{{ route('postregister') }}">
                @csrf
                <div class="form-group">
                    <select class="form-control" name="role">
                        <option value=""> Select Role </option>
                        <option value="1">Organizers</option>
                        <option value="2">Attendees</option>
                    </select>
                  </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="name" placeholder="Name">
                  </div>
                <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Confirm Password">
                  </div>
                <div class="mt-3 d-grid gap-2">
                    <input type="submit" value="SIGN UP" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">
                </div>
                <div class="text-center mt-4 fw-light"> Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
@endsection
