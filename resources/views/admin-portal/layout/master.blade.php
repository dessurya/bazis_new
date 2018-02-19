<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@yield('title')
@include('admin-portal.layout.head')

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        @include('admin-portal.layout.sidebar')

        @include('admin-portal.layout.header')

        <!-- page content -->
        <div class="right_col" role="main">
        @yield('content')
        </div>

        <footer>
          @include('admin-portal.layout.footer')
        </footer>
      </div>
    </div>


    @include('admin-portal.layout.bottomscript')
    @yield('script')
  </body>
</html>
