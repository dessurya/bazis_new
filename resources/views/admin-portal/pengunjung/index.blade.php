@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Pengunjung | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
  div.content{
    max-height: 260px;
    margin: 0 auto;
    padding: 10px;
    letter-spacing: 1px;
    line-height: 2;
    overflow-y: auto;
  }
  img.picture{
    max-height: 160px;
    max-width: 160px;
    float: right;
  }
  #pesan-respon{
    width: 85%;
    margin: 10px auto;
    border: .5px solid;
    border-radius: 5px;
    padding: 5px 10px;
    max-height: 200px;
    overflow-y:auto;
  }
</style>
<script src="{{asset('backend/vendors/ckeditor/ckeditor.js')}}"></script>
@endsection

@section('content')
  @if(Session::has('berhasil'))
    <script>
      window.setTimeout(function() {
        $(".alert-success").fadeTo(700, 0).slideUp(700, function(){
            $(this).remove();
        });
      }, 5000);
    </script>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong>{{ Session::get('berhasil') }}</strong>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Pengunjung </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Nama</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Bergabung</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($get as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>
                  {!! $key->nama !!}
                  {!! $key->identitas_no == null ? '' : '<br>'.$key->identitas_no.'('.$key->identitas_jenis.')' !!}
                  @if($key->foto != null)
                  <a href="{{$key->foto}}" target="_blank">
                    <img class="picture" src="{{$key->foto}}">
                  </a>
                  @endif
                </td>
                <td>
                    {!! $key->telpon == null ? '-' : $key->telpon !!}
                </td>
                <td>
                  {{ $key->email }}
                </td>
                <td>
                    {!! $key->created_at !!}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('script')
<script src="{{ asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
<script type="text/javascript">
  $('#table-data').DataTable();
</script>

@endsection
