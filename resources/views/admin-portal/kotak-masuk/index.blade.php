@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Kotak Masuk | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
  div.content{
    max-height: 260px;
    max-width: 320px;
    margin: 0 auto;
    padding: 10px;
    letter-spacing: 1px;
    line-height: 2;
    overflow-y: auto;
  }
  img.picture{
    max-height: 220px;
    max-width: 280px;
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

  <div class="modal fade modal-respon" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="form-respon" action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="title-respon"></h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <div id="pesan-respon"></div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Respon</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea 
                  id="respon" 
                  class="form-control col-md-7 col-xs-12" 
                  name="respon"
                >{{ old('respon') }}</textarea>
                @if($errors->has('respon'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('respon')}}</span></code>
                @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Kotak Masuk </h2>
          <ul class="nav panel_toolbox">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Status {{ $request->status != '' ? ' : '.$request->status : ' : Semua'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.kotakmasuk.inbox', ['status'=>'', 'author'=>$request->author]) }}">
                    Tampilkan Semua
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.kotakmasuk.inbox', ['status'=>'Respon', 'author'=>$request->author]) }}">
                    Tampilkan Yang Sudah Direspon
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.kotakmasuk.inbox', ['status'=>'Unrespon', 'author'=>$request->author]) }}">
                    Tampilkan Yang Belum Direspon
                  </a>
                </li>
              </ul>
            </div>
            <div class="btn-group">
              <a 
                class="btn btn-success btn-sm"
                href="{{ route('adpor.kotakmasuk.inbox') }}" 
              >
                <i class="fa fa-refresh"></i> Clear Filter
              </a>
            </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Pengirim</th>
                <th>Direspon Oleh</th>
                <th>Riwayat</th>
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
                  {!! $key->pengunjung->nama."<br>".$key->pengunjung->email !!}
                  {!! $key->pengunjung->telpon == null ? '' : '<br>'.$key->pengunjung->telpon !!}
                  <div class="content">
                    {!! $key->pesan !!}
                  </div>
                </td>
                <td>
                  @if($key->user_id != null)
                  {!! $key->getUser->name."<br>".$key->getUser->email !!}
                  <div class="content">
                    {!! $key->respon !!}
                  </div>
                  @else
                    <a 
                      href="" 
                      class="respon" 
                      data-value="{{ route('adpor.kotakmasuk.respon', ['id'=> encrypt($key->id)]) }}" 
                      data-toggle="modal" 
                      data-target=".modal-respon"
                      data-pengirim="{{ $key->pengunjung->nama.'/'.$key->pengunjung->email }}"
                      data-pesan="{{ $key->pesan }}"
                    >
                      <span 
                        class="btn btn-xs btn-info" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Klik Untuk Menulis Riwayat Balasan"
                      >
                        <i class="fa fa-pencil"></i> Buat Riwayat Balasan...
                      </span>
                    </a>
                  @endif
                </td>
                <td>{{ $key->created_at }}</td>
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

  $(function(){
    $('#table-data').on('click', 'a.respon', function(){
      var x = $(this).data('value');
      var a = $(this).data('pengirim');
      var b = $(this).data('pesan');
      $('#form-respon').attr('action', x);
      $('#title-respon').html("Kotak Masuk Dari "+a);
      $('#pesan-respon').html('Pesan : <br>'+b);
    });

  });
</script>

@if(Session::has('false-form'))
  <script>
    $('.modal-respon').modal('show');
    $('#form-respon').attr('action', "{{ Session::get('db_action') }}");
    $('#title-respon').html("Kotak Masuk Dari {{ Session::get('db_title') }}");
    $('#pesan-respon').html("Pesan : <br> {{ Session::get('db_pesan') }}");
  </script>
@endif

@endsection
