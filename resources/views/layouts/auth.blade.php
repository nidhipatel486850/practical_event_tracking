<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', Config::get('app.name') )</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href=" {{ asset('css/toastr.min.css') }}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
  </head>
  <body>
    @yield('content')
  </body>
  <script src="{{asset('theme/js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('js/toastr.min.js') }}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  @yield('page-script')
</html>
