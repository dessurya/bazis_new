@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Riwayat Penerimaan ZIS | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
  img.picture{
    max-height: 220px;
    max-width: 280px;
  }
  ul.dropdown-menu{
    max-height: 300px;
    overflow-y: auto;
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

  <div class="modal fade modal-aksi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content alert-danger">

        <div class="modal-header">
          <button 
            type="button" 
            class="close" 
            data-dismiss="modal" 
            aria-label="Close"
          >
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="title-aksi"></h4>
        </div>
        <div class="modal-body">
          <p>Anda Yakin Memulihkan ZIS Ini?</p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" id="aksi-recovery">Ya</a>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Riwayat Penerimaan ZIS </h2>
          <ul class="nav panel_toolbox">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Bank {{ $request->bank != '' ? ' : '.$request->bank : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>'', 'pemberi'=>$request->pemberi, 'delete'=>$request->delete]) }}">
                    All
                  </a>
                </li>
                @foreach($getBank as $data)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>$data->bank_nama, 'pemberi'=>$request->pemberi, 'delete'=>$request->delete]) }}">
                    {{ $data->bank_nama }}
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Pemberi {{ $request->pemberi != '' ? ' : '.$getFilterPemberi->nama : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>$request->bank, 'pemberi'=>'', 'delete'=>$request->delete]) }}">
                    All
                  </a>
                </li>
                @php $lastPemberi = 0 @endphp
                @foreach($pemberiList as $data)
                @if($lastPemberi != $data->pengunjung_id)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>$request->bank, 'pemberi'=>$data->pengunjung->email,  'delete'=>$request->delete]) }}">
                    {{ $data->pengunjung->nama }}
                  </a>
                </li>
                @endif
                @php $lastPemberi = $data->pengunjung_id @endphp
                @endforeach
              </ul>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Delete {{ $request->delete != '' ? ' : '.$getFilterdelete->name : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'delete'=>'']) }}">
                    All
                  </a>
                </li>
                @php $lastdelete = 0 @endphp
                @foreach($deleteList as $data)
                @if($lastdelete != $data->user_id)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.deleteIndex', ['bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'delete'=>$data->getUser->email]) }}">
                    {{ $data->getUser->name }}
                  </a>
                </li>
                @endif
                @php $lastdelete = $data->user_id @endphp
                @endforeach
              </ul>
            </div>
            <div class="btn-group">
              <a 
                class="btn btn-success btn-sm"
                href="{{ route('adpor.penzis.riwpen.deleteIndex') }}" 
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
                <th>ZIS</th>
                <th>Pemberi</th>
                <th>Bank</th>
                <th>Delete By</th>
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
                  {!! $key->no_zis.'<br>Jumlah Dibayarkan : Rp '.number_format($key->nominal, 2)  !!}
                  <a href="{{ asset('bukti/'.$key->bukti) }}" target="_blank">
                    <img class="picture" src="{{ asset('bukti/'.$key->bukti) }}">
                  </a>
                </td>
                <td>
                  {!! $key->pengunjung->nama.'<br>'.$key->pengunjung->email !!}
                  {!! $key->pengunjung->telpon == null ? '' : '<br>'.$key->pengunjung->telpon !!}
                  @if($key->pengunjung->foto != null)
                  <img class="picture" src="{{$key->pengunjung->foto}}">
                  @endif
                </td>
                <td>{!! $key->rekening->bank->bank_nama.'<br>'.$key->rekening->bank_rekening !!}</td>
                <td>
                    {!! $key->getUser->name."<br>".$key->getUser->email."<br>" !!}
                    <a 
                      href="" 
                      class="act-form" 
                      data-toggle="modal" 
                      data-target=".modal-aksi"
                      data-zis="{{ $key->no_zis }}"
                      data-url="{{ route('adpor.penzis.riwpen.recovery', ['id'=>encrypt($key->id)]) }}" 
                    >
                      <span 
                        class="btn btn-xs btn-danger" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Click to Recovery"
                      >
                        <i class="fa fa-plus"></i> Recovery
                      </span>
                    </a>
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
    $('#table-data').on('click', 'a.act-form', function(){
      var z = $(this).data('zis');
      var c = $(this).data('url');

      $('#aksi-recovery').attr('href', c);
      $('#title-aksi').html("Pulihkan ZIS : <br>"+z);
    });
  });
</script>

@endsection
