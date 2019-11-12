@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}">
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Management Product</h1>
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
                  @if ($message = Session::get('sukses21'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button> 
					<strong>{{ $message }}</strong>
				</div>
                @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">Data Product</div>

                <div class="card-body">
                   <a class="btn btn-success btn-sm" href="/produk/tambah"><i class="fa fa-plus">&nbsp Add Product</i></a><br><br>
  <div class="table-responsive">
	<table  class="table-hover table-striped table-bordered table-list tabelproduk">
                  <thead>
                    <tr style="vertical-align:middle;text-align:center;font-weigth:bold">
                        <th>No</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Status</th>
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
              ajax: '/produk/json',
              columns: [
                  { data: 'DT_RowIndex', name:'DT_RowIndex'},
                  { data: 'nama', name: 'nama' },
                  { data: 'link', name: 'link' },
                  {data: 'action', name: 'status', orderable: false, searchable: false},
                   { data: 'id', 
                   "render": function ( data, type, row, meta ) {
                            return '<center><a href="/produk/edit/'+data+'" title="edit" class="btn btn-xs btn-warning" style="margin-bottom:4px;margin-right:2px;"><i class="fa fa-edit"></i></a><a data-id="'+data+'" class="btn btn-xs btn-danger" style="margin-bottom:4px;" title="hapus" id="hapusproduk"><i class="fa fa-trash"></i></a></center>';
                       }
                }
                ]
          });

           $(document).on('click','#hapusproduk',function(){
            // dapetin dulu ID si usernya dari tag element button data-id
            var id = $(this).data('id')

            // kirim data ke server untuk hapus user dengan id 
            $.ajax({
              type: "DELETE",
              url: "/produk/hapus/" + id,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
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
          })

      });
   </script>
@endsection
