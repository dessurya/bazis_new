@extends('admin-portal.layout.master')

@section('title')
  <title>Portal Admin - Ubah Berita Artikel : {{ $get->title }} | Bazis Jakarta Utara</title>
@endsection

@section('headscript')
<script src="{{asset('backend/vendors/ckeditor/ckeditor.js')}}"></script>
<style type="text/css">
  img.picture{
    max-height: 480px;
    max-width: 680px;
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

  <div class="modal fade modal-form-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Ubah Berita Artikel : {{ $get->title }}</h2>
          <ul class="nav panel_toolbox">
            <a href="{{ route('adpor.berkel.index') }}" class="btn btn-success btn-sm"> Kembali</a>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <form action="{{ route('adpor.berkel.ubahSimpan', ['id'=>encrypt($get->id)]) }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input 
                    id="title" 
                    class="form-control col-md-7 col-xs-12" 
                    name="title" 
                    type="text" 
                    value="{{ $get->title,old('title') }}"
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
                  >{!! $get->content,old('content') !!}</textarea>
                  @if($errors->has('content'))
                    <code><span style="color:red; font-size:12px;">{{ $errors->first('content')}}</span></code>
                  @endif
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar Max 1024x1024</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" name="picture" type="file" accept=".jpg,.png">
                  @if($errors->has('picture'))
                    <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
                  @endif
                  <a href="{{ asset('asset/picture/berita-artikel/'.$get->picture) }}" target="_blank">
                    <img class="picture" src="{{ asset('asset/picture/berita-artikel/'.$get->picture) }}">
                  </a>
                </div>
              </div>
              <button id="send" type="submit" class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('script')
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

@endsection
