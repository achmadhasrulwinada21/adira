@extends('layouts.index')
@section('content')
<br><br>
<div class="container">
   <div class="row">
        <div class="col-md-12">
            <div class="card-header bg-info">Create Banner</div>
            <div class="card">
                 <div class="card-body">
	<form action="/banner/insert" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		  <br/>
        <label>Upload Gambar</label><br>
   <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" name="foto" accept="image/*">
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>
    <br/><br/>
    <label>Banner Thumbnail Alt.</label><br>
		<input type="text" name="alt_teks" class="form-control">
		 @if($errors->has('alt_teks'))
            <div class="text-danger">
             {{ $errors->first('alt_teks')}}
           </div>
        @endif
		 <br/>
    <label>Link</label><br>
		<input type="text" name="link" class="form-control" placeholder="isi Link...">
		 @if($errors->has('link'))
            <div class="text-danger">
             {{ $errors->first('link')}}
           </div>
        @endif
		 <br/>
        <label>Status</label><br>
        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" >
                    <option value="0" selected disabled>- Pilih Status -</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                            @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
		<input type="submit" value="Simpan Data" class="btn btn-info btn-sm">
	</form>

                </div>
    </div>
</div></div></div>

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