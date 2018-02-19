@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Users | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
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
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>{{ Session::get('berhasil') }}</strong>
    </div>
  </div>
</div>
@endif

<div class="modal fade modal-reset" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Reset Password</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
        <p>Reset Password Akun ini?</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setReset">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade modal-confirmed" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Aktifasi Akun</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
        <p>Mengaktifkan Akun ini?</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setConfirmed">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade modal-unconfirmed" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Non-Aktifasi Akun</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
        <p>Meng-nonaktifkan Akun ini?</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setUnconfirmed">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Delete Akun</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
        <p>Menghapus Akun ini?</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setDelete">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Buat Akun </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left" action="{{ route('adpor.user.store') }}" method="post">
          {{ csrf_field() }}
          <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control col-md-7 col-xs-12">
              @if($errors->has('name'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group  {{ $errors->has('email') ? 'has-error' : ''}}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Email</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control col-md-7 col-xs-12">
              @if($errors->has('email'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('email')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="box-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Your Account </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="{{ route('adpor.user.update.me') }}" method="post">
            {{ csrf_field() }}
            <div class="item form-group col-md-6 col-sm-12 col-xs-12 {{ $errors->has('me_name') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Nama</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="me_name" type="text" name="me_name" value="{{ old('me_name',Auth::user()->name) }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('me_name'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('me_name')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('me_email') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Email</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="me_email" type="email" name="me_email" value="{{ old('me_email',Auth::user()->email) }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('me_email'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('me_email')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('old_password') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Old Password</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="old_password" type="password" name="old_password" value="{{ old('old_password') }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('old_password') || Session::has('errors_oldpass'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('old_password')}}{{ Session::get('errors_oldpass') }}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('new_password') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">New Password</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="new_password" type="password" name="new_password" value="{{ old('new_password') }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('new_password'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('new_password')}}</span></code>
                @endif
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            <div class="box-footer">
              <button id="send" type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Daftar Pengguna </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="usertabel" class="table table-striped table-bordered no-footer">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Jumlah Login</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getUsers as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->name }}</td>
              <td>{{ $key->email }}</td>
              <td>{{ $key->login_count }}</td>
              <td>
                @if($key->id != Auth::user()->id)
                  <a 
                    href="" 
                    class="{{ $key->confirmed == 'Y' ? 'unconfirmed' : 'confirmed' }}" 
                    data-value="{{ route('adpor.user.status', ['id'=> encrypt($key->id)]) }}" 
                    data-toggle="modal" 
                    data-target="{{ $key->confirmed == 'Y' ? '.modal-unconfirmed' : '.modal-confirmed' }}"
                  >
                    <span 
                      class="btn btn-xs {{ $key->confirmed == 'Y' ? 'btn-success' : 'btn-danger'}}" 
                      data-toggle="tooltip" 
                      data-placement="top" 
                      title="{{ $key->confirmed == 'Y' ? 'Click to Unconfirmed' : ' Click to Confirmed'}}"
                    >
                      <i class="fa {{ $key->confirmed == 'Y' ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down' }}"></i>
                    </span>
                  </a>
                  <a 
                    href="" 
                    class="reset" 
                    data-value="{{ route('adpor.user.resetpassword', ['id'=> encrypt($key->id)]) }}" 
                    data-toggle="modal" 
                    data-target=".modal-reset"
                  >
                    <span 
                      class="btn btn-xs btn-danger reset" 
                      data-toggle="tooltip" 
                      data-placement="top" 
                      title="Click to Reset Password"
                    >
                      <i class="fa fa-recycle"></i>
                    </span>
                  </a>
                  <a 
                    href="" 
                    class="delete" 
                    data-value="{{ route('adpor.user.delete', ['id'=> encrypt($key->id)]) }}" 
                    data-toggle="modal" 
                    data-target=".modal-delete"
                  >
                    <span 
                      class="btn btn-xs btn-danger" 
                      data-toggle="tooltip" 
                      data-placement="top" 
                      title="Click to Delete"
                    >
                      <i class="fa fa-trash"></i>
                    </span>
                  </a>
                @else - @endif
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
  $('#usertabel').DataTable();

  $(function(){
    $('#usertabel').on('click', 'a.reset', function(){
      var a = $(this).data('value');
      $('#setReset').attr('href', a);
    });
    $('#usertabel').on('click', 'a.delete', function(){
      var a = $(this).data('value');
      $('#setDelete').attr('href', a);
    });
    $('#usertabel').on('click', 'a.confirmed', function(){
      var a = $(this).data('value');
      $('#setConfirmed').attr('href', a);
    });
    $('#usertabel').on('click', 'a.unconfirmed', function(){
      var a = $(this).data('value');
      $('#setUnconfirmed').attr('href', a);
    });
  });
</script>
@endsection
