<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', Config::get('app.name') )</title>
    <link rel="stylesheet" href="{{asset('theme/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href=" {{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
  </head>
  <body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div>
              <a class="navbar-brand brand-logo" href="{{route('dashboard')}}">
                <img src="{{asset('images/logo.svg')}}" alt="logo" />
              </a>
              <a class="navbar-brand brand-logo-mini" href="{{route('dashboard')}}">
                <img src="{{asset('images/logo.svg')}}" alt="logo" />
              </a>
            </div>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-top">

            <ul class="navbar-nav ms-auto">

              <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="img-xs rounded-circle" src="{{asset('images/faces/face8.jpg')}}" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header text-center">
                    <img class="img-md rounded-circle" src="{{asset('images/faces/face8.jpg')}}" alt="Profile image">
                    <p class="mb-1 mt-3 fw-semibold">{{ Auth()->user()->name }}</p>
                    <p class="fw-light text-muted mb-0">{{ Auth()->user()->email }}</p>
                  </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                @if(Auth()->user()->role == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                      <i class="mdi mdi-grid-large menu-icon"></i>
                      <span class="menu-title">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('event.index') }}">
                      <i class="mdi mdi-layers-outline menu-icon"></i>
                      <span class="menu-title">Events</span>
                    </a>
                  </li>
                @else
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('ticket.index') }}">
                      <i class="mdi mdi-floor-plan menu-icon"></i>
                      <span class="menu-title">Ticket Sales</span>
                    </a>
                  </li>
                @endif
            </ul>
          </nav>
          <!-- partial -->
          @yield('content')

          <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>


  </body>
  <script src="{{asset('theme/js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('js/toastr.min.js') }}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  @yield('page-script')
</html>
