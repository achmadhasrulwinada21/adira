@extends('layouts.index')
@section('content')
<br><br>
<div class="container">
       <div class="card-header bg-info">Edit Footer Brand</div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                       <form method="post" action="/footerbrand/update/{{ $footerbrand->id }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value=" {{ $footerbrand->nama }}">

                            @if($errors->has('nama'))
                                <div class="text-danger">
                                    {{ $errors->first('nama')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                        <label>Keterangan</label> 
                         <textarea id="content" class="form-control" name="ket">{{ $footerbrand->ket }}
                        </textarea>
                       </div>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                      <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" class="form-control" value=" {{ $footerbrand->link }}">
                            @if($errors->has('link'))
                                <div class="text-danger">
                                    {{ $errors->first('link')}}
                                </div>
                            @endif
                        </div>
                      <div class="form-group">
                        <label>Upload Gambar</label> 
                          <div class="row">
                             <div class="col s6">
                               <img src="{{ URL::to("$footerbrand->foto")}}" id="showgambar" style="max-width:200px;max-height:200px;float:left;" />
                             </div>
                        </div>
                        <br>
                    <div class="row">
                       <div class="input-field col s6">
                           <div class="custom-file">
                           <input type="file" id="inputgambar" name="foto" class="custom-file-input" accept="image/*"/ >
                         <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                       </div>
                   </div>
                </div>  
                <div class="form-group">
                <label>Thumbnail Alt.</label>
                <input type="text" name="alt_teks" class="form-control" value="{{ $footerbrand->alt_teks }}">
                </div>
                 <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                <option value="1" {{ $footerbrand->status == 1 ? 'selected="selected"' : '' }}>Aktif</option>
                <option value="0" {{ $footerbrand->status == 0 ? 'selected="selected"' : '' }}>Tidak Aktif</option>
                </select>
            </div>
             <div class="form-group">
                    <input type="submit"  value="Update" class="btn btn-success btn-sm">
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
  $(document).ready(function() {
    $('#content').summernote({
      height: "300px",
      styleWithSpan: false
    });
  }); 
</script>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
@endsection