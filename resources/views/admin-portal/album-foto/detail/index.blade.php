@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Album Foto : {{ $find->title }} | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/dropzone/dist/dropzone.css') }}">
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<script src="{{asset('backend/vendors/ckeditor/ckeditor.js')}}"></script>
<style type="text/css">
  div.picture{
    width: 100%;
    height: 200px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
  }
  .picture-panel{
    height: 160px;
  }
  .dropzone{
    overflow-y:auto;
    height: 350px;
  }
  .card{
    border: .5px solid;
    padding: 10px 5px;
    margin: 5px 10px;
  }
  .card div#img{
    height: 250px;
    width: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
  }
  input,
  textarea{
    width: 100% !important;
  }
</style>
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
          <h2>Album : {{ $find->title }}</h2>
          <ul class="nav panel_toolbox">
            <div class="btn-group">
              <a 
                class="btn btn-success btn-sm"
                href="{{ route('adpor.albfot.index') }}" 
              >
                <i class="fa fa-level-up"></i> Kembali Ke List Album Foto
              </a>
            </div>
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-success btn-sm"
                data-toggle="collapse" data-target="#targetDetail"
              >
                <i class="fa fa-chevron-down"></i> 
              </button>
            </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div id="targetDetail" class="collapse @if($request->flag == null) in @endif x_content table-responsive">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <form action="{{ route('adpor.albfot.ubahSimpan', ['id'=>encrypt($find->id)]) }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="item form-group">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Title</label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input type="hidden" name="indetail" value="true">
                      <input 
                        id="title" 
                        class="form-control col-md-7 col-xs-12" 
                        name="title" 
                        type="text" 
                        value="{{ $find->title,old('title') }}"
                      >
                      @if($errors->has('title'))
                        <code><span style="color:red; font-size:12px;">{{ $errors->first('title')}}</span></code>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                      Content
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <textarea 
                        id="content" 
                        class="form-control col-md-12 col-xs-12" 
                        name="content"
                      >{{ $find->content,old('content') }}</textarea>
                      @if($errors->has('content'))
                        <code><span style="color:red; font-size:12px;">{{ $errors->first('content')}}</span></code>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button id="send" type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <h5 class="text-center">Upload Foto Disini</h5>
              <form 
                action="{{ route('adpor.albfotdet.simpan', ['id'=>encrypt($find->id)]) }}" 
                method="post" 
                enctype="multipart/form-data" 
                class="dropzone" 
                id="my-dropzone"
              >
                  {{ csrf_field() }}
              </form>
                <h2 class="text-center">Sampul Album</h2>
                  <div id="sampulAlbum" class="picture" style="background-image: url('{{ asset('asset/picture/album-foto/'.$find->picture) }}');">
                  </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Album : {{ $find->title }}</h2>
          <ul class="nav panel_toolbox">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">
                Flag {{ $request->flag != '' ? ' : '.$request->flag : ' : All'}}
              </button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret" style="color:white;"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('adpor.albfotdet', ['id'=>encrypt($find->id), 'flag'=>'']) }}">
                    Show All
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.albfotdet', ['id'=>encrypt($find->id), 'flag'=>'Publis']) }}">
                    Show Publis
                  </a>
                </li>
                <li>
                  <a href="{{ route('adpor.albfotdet', ['id'=>encrypt($find->id), 'flag'=>'Unpublis']) }}">
                    Show Unpublis
                  </a>
                </li>
              </ul>
            </div>
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-success btn-sm"
                data-toggle="collapse" data-target="#list-foto"
              >
                <i class="fa fa-chevron-down"></i> 
              </button>
            </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div id="list-foto" class="collapse @if($request->flag != null) in @endif x_content table-responsive">
          <table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>Data</th>
              </tr>
            </thead>
            <tbody>
                @foreach($get as $pict)
                <tr class="{{$pict->title}}">
                  <td>
                    <div class="card col-md-11 col-sm-11 col-xs-11">
                      <form 
                        class="detail-pict" 
                        action="{{ route('adpor.albfotdet.tools', ['id'=>encrypt($find->id), 'subId'=>encrypt($pict->id)]) }}" 
                        method="POST" 
                        class="form-horizontal form-label-left"
                      >
                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="card-body">
                              <a href="{{ asset('asset/picture/album-foto/'.$pict->picture) }}" target="_blank">
                                <div id="img" style="background-image: url('{{ asset('asset/picture/album-foto/'.$pict->picture) }}');"></div>
                              </a>
                            </div>
                          </div>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="card-body">
                              <h5 class="card-title">Picture Details and Form Update</h5>
                              <p class="card-text">
                                Title :
                              </p>
                              <input 
                                id="title" 
                                name="title" 
                                class="form-control" 
                                type="text" 
                                value="{{ $pict->title }}"
                              >
                              <p class="card-text">
                                Content :
                              </p>
                              <textarea 
                                  id="content" 
                                  name="content"
                                  class="form-control" 
                                >{{ $pict->content }}</textarea>
                            </div>
                            <div class="card-body text-right">
                              <hr>
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" id="save" class="toolsPict btn btn-success">
                                  Save
                                </button>
                                <button type="button" id="flag" class="toolsPict btn {{ $pict->flag == 'Y' ? 'btn-info' : 'btn-danger' }}" data-toggle="tooltip" data-placement="top" title="{{ $pict->flag == 'Y' ? 'Click to Unpublis' : 'Click to Publis' }}">
                                  {{ $pict->flag == 'Y' ? 'Publish' : 'Un-Publish'}}
                                </button>
                                <button type="button" id="cover" class="toolsPict btn btn-warning">
                                  Cover
                                </button>
                                <button type="button" id="delete" class="toolsPict btn btn-danger">
                                  Delete
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
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
</script>

<script src="{{ asset('backend/vendors/dropzone/dist/dropzone.js') }}"></script>
<script type="text/javascript">
  var dtTables = $('#table-data').DataTable({
    searching: false
  });

  Dropzone.options.myDropzone = {
    maxFilesize  : 5,
      acceptedFiles: ".jpeg,.jpg,.png,.gif",
      success: function(file, response){
        var text = response.msg;
        if (response.action == true) {
            dtTables.row.add([
              response.resault
            ]).draw();
        }
        else{
          if(typeof(response.resault.file) != "undefined" && response.resault.file !== null){
            text = text + response.resault.file.toString();
          }
          else{
            text = text + response.resault
          }
        }
        alert(text);
      }
    };
</script>

<script type="text/javascript">
  $(function(){
    var action = null;
    $(document).on('click', 'button.toolsPict ', function(){
      action = $(this).attr('id');
      $(this).parents('form:first').submit();
    });
    $(document).on('submit', 'form.detail-pict', function(){
      var rows  = $(this).parents('tr:first');
      var form  = $(this);
      var url   = $(this).attr('action');
      var data  = $(this).serializeArray();
      if (action == null) {
        action = 'save';
      };
      data.push(
        { name : 'action', value: action}
      );

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data,
        beforeSend: function() {},
        success: function(data) {
            alert(data.msg);
            if(data.action == 'flag'){
              if(data.flag=='Y'){
                var btn = 'btn-info';
                var title = 'Click to Unpublis';
                var text = 'Publis';
              }else{
                var btn = 'btn-danger';
                var title = 'Click to Publis';
                var text = 'Un-Publis';
              }
              form.find('button#flag').attr('class', 'toolsPict btn '+ btn);
              form.find('button#flag').attr('title', title);
              form.find('button#flag').attr('data-original-title', title);
              form.find('button#flag').html(text);
            }
            if(data.action == 'cover'){
              var style = form.find('div#img').attr('style');
              $('div#sampulAlbum.picture').attr('style',style);
            }
            if(data.action == 'delete'){
              window.setTimeout(function() {
                dtTables.row(rows).remove().draw();
              }, 500);
            }
        }
      });
      return false;
    });
  });
</script>
@endsection
