@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Dashboard | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<script src="{{ asset('amadeo/vendors/Chart.js/dist/Chart.min.js')}}"></script>
@endsection

@section('content')

  <div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-phone"></i></span>
      <div class="count blue"></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-phone"></i></span>
      <div class="count red"></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-beer"></i></span>
      <div class="count green"></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-anchor"></i></span>
      <div class="count yellow"></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-anchor"></i></span>
      <div class="count purple"></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-suitcase"></i></span>
      <div class="count green"></div>
    </div>
  </div>


@endsection

@section('script')

@endsection
