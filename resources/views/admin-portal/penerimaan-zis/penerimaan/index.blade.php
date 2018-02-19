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
          <p>Apa semua data telah benar ?</p>
          <p>Anda Yakin ?</p>
          <p>Jika Ya Benar Maka Pilihlah Confirmed Untuk Mengesahkan ZIS...</p>
          <p>Jika Ya Tidak Maka Pilihlah Delete Untuk Menghapus ZIS...</p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" style="float: left;" id="aksi-confirmed">Confirmed</a>
          <a class="btn btn-primary" style="float: right;" id="aksi-delete">Delete</a>
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
                Status {{ $request->status != '' ? ' : '.$request->status : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>'', 'bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'confirmed'=>$request->confirmed]) }}">
                    All
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>'Pending', 'bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'confirmed'=>'']) }}">
                    Pending
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>'Confirmed', 'bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'confirmed'=>$request->confirmed]) }}">
                    Confirmed
                  </a>
                </li>
              </ul>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Bank {{ $request->bank != '' ? ' : '.$request->bank : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>$request->status, 'bank'=>'', 'pemberi'=>$request->pemberi, 'confirmed'=>$request->confirmed]) }}">
                    All
                  </a>
                </li>
                @foreach($getBank as $data)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>$request->status, 'bank'=>$data->bank_nama, 'pemberi'=>$request->pemberi, 'confirmed'=>$request->confirmed]) }}">
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
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>$request->status, 'bank'=>$request->bank, 'pemberi'=>'', 'confirmed'=>$request->confirmed]) }}">
                    All
                  </a>
                </li>
                @php $lastPemberi = 0 @endphp
                @foreach($pemberiList as $data)
                @if($lastPemberi != $data->pengunjung_id)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>$request->status, 'bank'=>$request->bank, 'pemberi'=>$data->pengunjung->email,  'confirmed'=>$request->confirmed]) }}">
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
                Confirmed {{ $request->confirmed != '' ? ' : '.$getFilterconfirmed->name : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>'Confirmed', 'bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'confirmed'=>'']) }}">
                    All
                  </a>
                </li>
                @php $lastconfirmed = 0 @endphp
                @foreach($confirmedList as $data)
                @if($lastconfirmed != $data->user_id)
                <li>
                  <a href="{{ route('adpor.penzis.riwpen.index', ['status'=>'Confirmed', 'bank'=>$request->bank, 'pemberi'=>$request->pemberi, 'confirmed'=>$data->getUser->email]) }}">
                    {{ $data->getUser->name }}
                  </a>
                </li>
                @endif
                @php $lastconfirmed = $data->user_id @endphp
                @endforeach
              </ul>
            </div>
            <div class="btn-group">
              <a 
                class="btn btn-success btn-sm"
                href="{{ route('adpor.penzis.riwpen.index') }}" 
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
                <th>Status</th>
                <th>Confirmed By</th>
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
                    @if($key->flag == 'N')
                      <a 
                        href="" 
                        class="act-form" 
                        data-toggle="modal" 
                        data-target=".modal-aksi"
                        data-zis="{{ $key->no_zis }}"
                        data-confirmed="{{ route('adpor.penzis.riwpen.confirmed', ['id'=>encrypt($key->id)]) }}" 
                        data-delete="{{ route('adpor.penzis.riwpen.delete', ['id'=>encrypt($key->id)]) }}" 
                      >
                        <span 
                          class="btn btn-xs btn-danger" 
                          data-toggle="tooltip" 
                          data-placement="top" 
                          title="Click to Open Action Form"
                        >
                          <i class="fa fa-minus"></i> Pending
                        </span>
                      </a>
                    @elseif($key->flag == 'Y')
                      <a>
                        <span 
                          class="btn btn-xs btn-success" 
                          data-toggle="tooltip" 
                          data-placement="top" 
                          title="ZIS Telah Disahkan Oleh {{ $key->getUser->name }}"
                        >
                          <i class="fa fa-check"></i> Confirmed
                        </span>
                      </a>
                    @endif
                </td>
                <td>{!! $key->user_id == null ? '-' : $key->getUser->name."<br>".$key->getUser->email !!}</td>
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
      var c = $(this).data('confirmed');
      var d = $(this).data('delete');

      $('#aksi-confirmed').attr('href', c);
      $('#aksi-delete').attr('href', d);
      $('#title-aksi').html("Action Form For ZIS : <br>"+z);
    });
  });
</script>

@endsection
