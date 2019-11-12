@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}">
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0 text-dark">Management File</h1>
             </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<section class="content">
      <div class="container">
              @if ($message = Session::get('sukses'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button> 
					<strong>{{ $message }}</strong>
				</div>
                @endif
          <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">Data File</div>

                <div class="card-body">
<a class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" style="color:white;"><i class="fa fa-plus">&nbsp Add File</i></a><br><br>
  <div class="table-responsive">
	<table  class="table-hover table-striped table-bordered table-list tabelproduk">
                  <thead>
                    <tr style="vertical-align:middle;text-align:center;font-weigth:bold">
                        <th>No</th>
                        <th>File</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Action</th>
                      </tr> 
                  </thead>
                  <tbody><tbody>
                </table>
   </div></div>
             </div>
        </div>
    </div>
      </div>
   <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
           <h4 class="modal-title">Add File</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
      <div class="modal-body">
        <form action="/file/insert" method="post" enctype="multipart/form-data" id="productForm">
            {{ csrf_field() }}
                   <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">File</label>
                        <div class="col-sm-12">
                            <div class="custom-file">
                         <input type="file" class="custom-file-input" id="customFile" name="foto">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                         </div>
                     </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">File Thumbnail Alt.</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  name="alt_teks"  value="" maxlength="50" required>
                     </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  name="ket" placeholder="Enter keterangan" value="" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-12">
                    <select name="id_kategori" class="form-control" >
                    <option value="0" selected disabled>- Choose Category File -</option>
                    @foreach ($kategori as $pemilik)
                        <option value="{{ $pemilik->id }}">{{ ($pemilik->kategori) }}</option>
                    @endforeach
                     </select>
                     </div>
                    </div>
                   <br>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary"  value="create" id="saveBtn">Save changes
                     </button>
                    </div>
                </form>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <?php
      foreach($file as $i){
      $id= $i['id'];
      $ket= $i['ket'];
      $foto= $i['foto'];
      $alt_teks= $i['alt_teks'];
      $id_kategori = $i['id_kategori'];
         ?>
<div id="modal_edit{{ $id }}" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
           <h4 class="modal-title">Update File</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
      <div class="modal-body">
        <form action="/file/update/{{ $id }}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
                  <input type="hidden" value="{{ $id }}">
                 <div class="form-group">
                        <label>Upload File</label> 
                          <div class="row">
                             <div class="col s6">
                              <a href="{{ URL::to("$foto")}}" target="blank"><img src="{{ URL::to("/assets/files.png")}}" id="showgambar2" style="max-width:50px;max-height:50px;float:left;" /></a>
                            </div>
                        </div>
                        <br>
                    <div class="row">
                       <div class="input-field col s6">
                            <div class="custom-file">
                           <input type="file" id="inputgambar2" name="foto" class="custom-file-input">
                         <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                       </div>
                   </div>
                </div> 
                <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">File Thumbnail Alt.</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  name="alt_teks" value="{{ $alt_teks }}" maxlength="50" required>
                     </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control"  name="ket" value="{{ $ket }}" placeholder="Enter keterangan" value="" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-12">
                    <select name="id_kategori"  class="form-control" >
                    <option value="0" selected disabled>- Choose Category File -</option>
                    @foreach ($kategori as $pemilik)
                        <option value="{{ $pemilik->id }}" {{ $id_kategori == $pemilik->id ? 'selected="selected"' : '' }}>{{ ($pemilik->kategori) }}</option>
                    @endforeach
                     </select>
                     </div>
                    </div>
                   <br>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary"  value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <?php } ?>
</section>
 <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
 <script>

     $(function() {
         
          $.ajaxSetup({
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
          var table_kat = $('.tabelproduk').DataTable({
              processing: true,
              serverSide: true,
              ajax: '/file/json',
              columns: [
                  { data: 'DT_RowIndex', name:'DT_RowIndex'},
                   { data: 'foto',
                  'searchable': false,
                  'orderable':false,
                  'render': function (data, type, full, meta)
                     {
                    return '<center><a href="{{ $settingweb->link_web}}/'+data+'" target="blank"><img src="{{ URL::to("/assets/files.png")}}" style="height:50px;width:50px;"/></a></center>';
                       }
                   },               
                  { data: 'ket', name: 'ket' },
                  { data: 'kategori', name: 'kategori' },
                 {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
          });
    
        $('body').on('click', '.deleteProduct', function () {
        var id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: "/file/destroy"+'/'+id,
             success: function(data){
                var json  = JSON.parse(data)

                switch (json.code) {
                  case 200:
                     Swal.fire({
                                type: 'success',
                                title: 'Oops...',
                                text: 'Data has been Deleted!',
                            })
                    break;
                  default:
                    break;
                }

                // refresh datatablesnya kalau sudah menghapus usernya
                table_kat.ajax.reload()
              }
           
        });
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