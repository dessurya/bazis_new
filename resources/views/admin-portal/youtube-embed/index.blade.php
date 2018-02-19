@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Video Youtube | Bazis Jakarta Utara</title>
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

  <div class="modal fade modal-form-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('adpor.viyou.simpan') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Tambah Video Youtube</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input 
                  id="title" 
                  class="form-control col-md-7 col-xs-12" 
                  name="title" 
                  type="text" 
                  value="{{ old('title') }}"
                >
                @if($errors->has('title'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('title')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Content</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea 
                  id="content" 
                  class="form-control col-md-7 col-xs-12" 
                  name="content"
                >{{ old('content') }}</textarea>
                @if($errors->has('content'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('content')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Youtube</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input 
                  id="url_youtube" 
                  class="form-control col-md-7 col-xs-12" 
                  name="url_youtube" 
                  type="text"
                  value="{{ old('url_youtube') }}" 
                >
                @if($errors->has('url_youtube'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('url_youtube')}}</span></code>
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

  <div class="modal fade modal-form-update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="form-update" action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="title-update"></h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input 
                  id="fildUp_title" 
                  class="form-control col-md-7 col-xs-12" 
                  name="fildUp_title" 
                  type="text" 
                  value="{{ old('fildUp_title') }}"
                >
                @if($errors->has('fildUp_title'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('fildUp_title')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Content</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea 
                  id="fildUp_content" 
                  class="form-control col-md-7 col-xs-12" 
                  name="fildUp_content"
                >{{ old('fildUp_content') }}</textarea>
                @if($errors->has('fildUp_content'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('fildUp_content')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Youtube</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input 
                  id="fildUp_url_youtube" 
                  class="form-control col-md-7 col-xs-12" 
                  name="fildUp_url_youtube" 
                  type="text"
                  value="{{ old('fildUp_url_youtube') }}" 
                >
                @if($errors->has('fildUp_url_youtube'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('fildUp_url_youtube')}}</span></code>
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
          <h4>Yakin ?</h4>
          <p id="text-aksi">?</p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" id="aksi-url">Ya</a>
        </div>

      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Video Youtube </h2>
          <ul class="nav panel_toolbox">
            <div class="btn-group">
              <button 
                type="button"
                class="btn btn-success btn-sm" 
                data-toggle='modal' 
                data-target='.modal-form-add'
              >
                <i class="fa fa-plus"></i> Tambah
              </button>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Flag {{ $request->flag != '' ? ' : '.$request->flag : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.viyou.index', ['flag'=>'', 'author'=>$request->author]) }}">
                    Show All
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.viyou.index', ['flag'=>'Publis', 'author'=>$request->author]) }}">
                    Show Publis
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.viyou.index', ['flag'=>'Unpublis', 'author'=>$request->author]) }}">
                    Show Unpublis
                  </a>
                </li>
              </ul>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Author {{ $request->author != '' ? ' : '.$getFilterAuthor->name : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.viyou.index', ['flag'=>$request->flag, 'author'=>'']) }}">
                    Show All
                  </a>
                </li>
                @php $lastAuthor = 0 @endphp
                @foreach($authorList as $data)
                @if($lastAuthor != $data->user_id)
                <li>
                  <a href="{{ route('adpor.viyou.index', ['flag'=>$request->flag, 'author'=>$data->getUser->email]) }}">
                    {{ $data->getUser->name }}
                  </a>
                </li>
                @endif
                @php $lastAuthor = $data->user_id @endphp
                @endforeach
              </ul>
            </div>
            <div class="btn-group">
              <a 
                class="btn btn-success btn-sm"
                href="{{ route('adpor.viyou.index') }}" 
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
                <th>Title</th>
                <th>Content</th>
                <th>Author</th>
                <th>Riwayat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($get as $key)
              @php
                $url      = $key->url_youtube;
                $step1      = explode('v=', $url);
                $step2      = explode('&',$step1[1]);
                $vedio_id     = $step2[0];

                $thumbnail    = 'http://img.youtube.com/vi/'.$vedio_id.'/0.jpg';
                $vedio_embed    = 'http://www.youtube.com/embed/'.$vedio_id;
              @endphp

              <tr>
                <td>{{ $no++ }}</td>
                <td>
                  {!! $key->title !!}
                  <br>
                  <img class="picture" src="{{ $thumbnail }}">
                </td>
                <td>
                  <div class="content">
                    {!! $key->content !!}
                  </div>
                </td>
                <td>
                  {!! $key->getUser->name."<br>".$key->getUser->email !!}
                </td>
                <td>{{ $key->created_at }}</td>
                <td>
                  <a 
                    href="" 
                    class="{{ $key->flag == 'Y' ? 'unpublis' : 'publis' }}" 
                    data-value="{{ route('adpor.viyou.flag', ['id'=> encrypt($key->id)]) }}" 
                    data-toggle="modal" 
                    data-target=".modal-aksi"
                  >
                    <span 
                      class="btn btn-xs {{ $key->flag == 'Y' ? 'btn-success' : 'btn-danger' }}" 
                      data-toggle="tooltip" 
                      data-placement="top" 
                      title="{{ $key->flag == 'Y' ? 'Click to Unpublis' : 'Click to Publis' }}"
                    >
                      <i class="fa {{ $key->flag == 'Y' ? 'fa-thumbs-up' : 'fa-thumbs-down' }}"></i>
                    </span>
                  </a>
                  <a 
                    href="" 
                    class="delete" 
                    data-value="{{ route('adpor.viyou.hapus', ['id'=> encrypt($key->id)]) }}" 
                    data-toggle="modal" 
                    data-target=".modal-aksi"
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
                  <a 
                    href="" 
                    data-toggle='modal' 
                    data-target='.modal-form-update'
                    data-action="{{ route('adpor.viyou.ubahSimpan', ['id'=> encrypt($key->id)]) }}" 
                    data-id='{{ $key->id }}'
                    data-title='{{ $key->title }}'
                    data-content='{{ $key->content }}'
                    data-urlyoutube='{{ $key->url_youtube }}'
                    class="update" 
                  >
                    <span 
                      class="btn btn-xs btn-info" 
                      data-toggle="tooltip" 
                      data-placement="top" 
                      title="Click to Update"
                    >
                      <i class="fa fa-pencil-square-o"></i>
                    </span>
                  </a>
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

  $(function(){
    $('#table-data').on('click', 'a.delete', function(){
      var a = $(this).data('value');
      $('#aksi-url').attr('href', a);
      $('#title-aksi').html("Menghapus Video Youtube");
      $('#text-aksi').html("Menghapus Video Youtube Ini?");
    });
    $('#table-data').on('click', 'a.publis', function(){
      var a = $(this).data('value');
      $('#aksi-url').attr('href', a);
      $('#title-aksi').html("Publikasi Video Youtube");
      $('#text-aksi').html("Meng-publikasi Video Youtube Ini?");
    });
    $('#table-data').on('click', 'a.unpublis', function(){
      var a = $(this).data('value');
      $('#aksi-url').attr('href', a);
      $('#title-aksi').html("Non-Publikasi Video Youtube");
      $('#text-aksi').html("Meng-Non-publikasi Video Youtube Ini?");
    });

    $('#table-data').on('click', 'a.update', function(){
      var x = $(this).data('action');
      var a = $(this).data('id');
      var b = $(this).data('title');
      var c = $(this).data('content');
      var d = $(this).data('urlyoutube');
      $('#form-update').attr('action', x);
      $('#title-update').html("Update Video Youtube "+b);
      $('#fildUp_title').attr('value', b);
      $('#fildUp_url_youtube').attr('value', d);
      CKEDITOR.instances['fildUp_content'].setData(c);
    });

  });
</script>

<script type="text/javascript">
  CKEDITOR.replace('content', {
    toolbar: [
      { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
      { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
      { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
      { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
      { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
      { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
      { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
      { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
      { name: 'others', items: [ '-' ] }
    ]
  });
  CKEDITOR.replace('fildUp_content', {
    toolbar: [
      { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
      { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
      { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
      { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
      { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
      { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
      { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
      { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
      { name: 'others', items: [ '-' ] }
    ]
  });
</script>

@if(Session::has('false-form'))
  <script>
    $('.modal-form-add').modal('show');
  </script>
@endif

@if(Session::has('false-form-update'))
  <script>
    $('.modal-form-update').modal('show');
    $('#form-update').attr('action', "{{ Session::get('db_action') }}");
    $('#title-update').html("Update Video Youtube {{ Session::get('db_title') }}");
  </script>
@endif

@endsection
