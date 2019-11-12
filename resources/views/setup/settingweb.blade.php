@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}">
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h1 class="m-0 text-dark">Setup Web</h1>
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
    <div class="row">
         <div class="col-md-6">
       <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Tabs</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Title</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Company</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Sosial Media</a></li>
                </ul>
              </div><!-- /.card-header -->
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1"> 
  <form action="/settingweb/update" method="post" class="form-horizontal" enctype="multipart/form-data">
  {{ csrf_field() }}
   {{ method_field('PUT') }}
  <br>
            <input type="hidden" name="id" id="id" value="{{ $settingweb->id }}">
                <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Title Web</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ $settingweb->title }}" maxlength="50" required>
               </div>
                    </div>
                    <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Nama Web</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nm_web" name="nm_web" placeholder="Enter nama web" value="{{ $settingweb->nm_web }}" maxlength="50" required>
                     </div></div>
                     <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Logo Web</label>
                        <div class="col-sm-12">
                          <div class="row">
                             <div class="col s6">
                            <img src="{{ URL::to("$settingweb->logo_web")}}" id="showgambar" style="max-width:200px;max-height:200px;float:left;" />    
                          </div>
                        </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="logo_web" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                          </div>
                          </div>
                      <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Logo Web Alternative Teks</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="alt_teks" name="alt_teks" placeholder="Enter alt teks" value="{{ $settingweb->alt_teks }}" maxlength="50">
                     </div></div>
                     <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Link Web</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="link_web" name="link_web" placeholder="Enter link web" value="{{ $settingweb->link_web }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="col-sm-offset-2 col-sm-10" style="margin-left:12px;margin-right:12px;">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><span class="fa fa-save">&nbspSave changes</span>
                     </button>
                    </div>
                </form></div>
           <div class="tab-pane" id="tab_2"> 
                <form action="/settingweb/update_perusahaan" method="post" class="form-horizontal" enctype="multipart/form-data">
  {{ csrf_field() }}
   {{ method_field('PUT') }}
  <br>
            <input type="hidden" name="id" id="id" value="{{ $settingweb->id }}">
               
            <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Perusahaan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nm_perusahaan" name="nm_perusahaan" placeholder="Enter perusahaan" value="{{ $settingweb->nm_perusahaan }}" maxlength="50" required>
               </div>
                    </div>
                    <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Alamat</label>
                        <div class="col-sm-12">
                      <textarea class="form-control" name="alamat" id="alamat" required>{{ $settingweb->alamat }}</textarea>
                     </div></div>
                    <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">No Telp</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Enter NO Telpon" value="{{ $settingweb->no_telp }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Fax</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fax" name="fax" placeholder="Enter NO Fax" value="{{ $settingweb->fax }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter NO Fax" value="{{ $settingweb->email }}" maxlength="50" required>
                     </div>
                    </div>
                      <div class="form-group" style="margin-left:12px;margin-right:12px;">
                        <label for="name" class="col-sm-4 control-label">Copyright</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="copyright" name="copyright" placeholder="Enter link web" value="{{ $settingweb->copyright }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="col-sm-offset-2 col-sm-10" style="margin-left:12px;margin-right:12px;">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><span class="fa fa-save">&nbspSave changes</span>
                     </button>
                    </div>
                </form></div>
            <div class="tab-pane" id="tab_3"> 
               <form action="/settingweb/update_sosmed" method="post" class="form-horizontal" enctype="multipart/form-data">
  {{ csrf_field() }}
   {{ method_field('PUT') }}
  <br>
            <input type="hidden" name="id" id="id" value="{{ $settingweb->id }}">
         <div class="col-md-12">
             <div class="row">
                 <div class="form-group" style="margin-left:30px;margin-right:12px;">
                        <label for="name" class="col-sm-12 control-label">Logo Facebook</label>
                        <div class="col-md-12">
                          <div class="row">
                             <div class="col s6">
                             <img src="{{ URL::to("$settingweb->logo_sosmed1")}}" id="showgambar" style="max-width:100px;max-height:100px;float:left;" />
                          </div>
                        </div><br>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="logo_sosmed1" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div><br><br>
                               <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Link Facebook</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="link_web" name="link_sosmed1" placeholder="Enter link web" value="{{ $settingweb->link_sosmed1 }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Alt teks Facebook</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="alt_teks_fb" name="alt_teks_fb" placeholder="Enter alt teks fb" value="{{ $settingweb->alt_teks_fb }}" maxlength="50" required>
                     </div>
                    </div>
                          </div>
                          </div>
                   <div class="form-group" style="margin-left:30px;margin-right:12px;">
                        <label for="name" class="col-sm-12 control-label">Logo Instagram</label>
                        <div class="col-md-12">
                          <div class="row">
                             <div class="col s6">
                              <img src="{{ URL::to("$settingweb->logo_sosmed2")}}" id="showgambar" style="max-width:100px;max-height:100px;float:left;" />
                               </div>
                        </div><br>
                          <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="logo_sosmed2" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                              <br><br>
                               <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Link Instagram</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="link_web" name="link_sosmed2" placeholder="Enter link web" value="{{ $settingweb->link_sosmed2 }}" maxlength="50" required>
                     </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Alt teks Instagram</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="alt_teks_ig" name="alt_teks_ig" placeholder="Enter alt teks ig" value="{{ $settingweb->alt_teks_ig }}" maxlength="50" required>
                     </div>
                          </div>
                          </div></div>
                    <div class="form-group" style="margin-left:30px;margin-right:12px;">
                        <label for="name" class="col-sm-12 control-label">Logo Twitter</label>
                        <div class="col-md-12">
                          <div class="row">
                             <div class="col s6">
                               <img src="{{ URL::to("$settingweb->logo_sosmed3")}}" id="showgambar" style="max-width:100px;max-height:100px;float:left;" />
                            </div>
                        </div><br>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="logo_sosmed3" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                              <br><br>
                      <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Link Twitter</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="link_web" name="link_sosmed3" placeholder="Enter link web" value="{{ $settingweb->link_sosmed3 }}" maxlength="50" required>
                     </div>
                    </div>
                        <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Alt teks Twitter</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="alt_teks_twit" name="alt_teks_twit" placeholder="Enter alt teks twitter" value="{{ $settingweb->alt_teks_twit }}" maxlength="50" required>
                     </div>
                          </div>
                          </div>
                          </div>
                        </div>
                     
           <div class="col-sm-offset-2 col-sm-10" style="margin-left:30px;margin-right:12px;">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><span class="fa fa-save">&nbspSave changes</span>
                     </button>
                    </div>
                </form>
            </div></div>
              <div class="card-body">
        </div>
    </div>
      </div>
    </div>
</div>

 </section>
   <!-- /.content -->
   <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
@endsection