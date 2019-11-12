<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Banner;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;

class BannerController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function json(){
        $banner = Banner::all();
        return Datatables::of($banner)
         ->addColumn('action', function ($banner) {
             $status=$banner->status;
             if($status==1){
                $status='<center><b style="color:blue;">Aktif</b></center>';
             }else{
                $status='<center><b style="color:red;">Tidak Aktif</b></center>';
             }
                return 
                '<span>'.$status.'</span>';
            }
        )
        ->addIndexColumn()
        ->make(true);
    }

     public function index(){
        $banner = Banner::all();
        $settingweb = Settingweb::find('001');
    	return view('master.banner.banner',['banner' => $banner,'settingweb' => $settingweb]);
    }

    public function tambah(){
        $banner = Banner::all();
        $settingweb = Settingweb::find('001');
    	return view('master.banner.tambah_banner',['banner' => $banner,'settingweb' => $settingweb]);
  }

  public function insert(Request $request) {
               
    	$this->validate($request,[
            'foto' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
            'link' => 'required',
            'alt_teks' => 'required',
         ]);

         // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        $path       = 'data_file/foto_banner/';
		$nama_file = $path.$file->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload =  $path;
        $file->move($tujuan_upload,$nama_file);
                
        Banner::create([
            'foto' => $nama_file,
            'status' => $request->status,
            'link' => $request->link,
            'alt_teks' => $request->alt_teks,
        ]);
        
         Session::flash('sukses','Banner Telah Ditambahkan');
        return redirect('/admin/banner');
    }

     public function edit($id){
      $banner = Banner::find($id);
      $settingweb = Settingweb::find('001');
       return view('master.banner.edit_banner', ['banner' => $banner,'settingweb' => $settingweb]);
    }

     public function update($id, Request $request){
    $this->validate($request,[
	    'foto' =>'file|image|mimes:jpeg,png,jpg|max:2048',
        'link' => 'required',
        'status' => 'required',
        'alt_teks' => 'required',
    ]);

    $banner = Banner::find($id);

    if($request->file('foto') == "")
        {
            $banner->foto = $banner->foto;
        } 
        else
        {
            File::delete($banner->foto);
            $file       = $request->file('foto');
            $path       = 'data_file/foto_banner/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $banner->foto = $fileName;
        }
   
    
    $banner->link = $request->link;
    $banner->alt_teks = $request->alt_teks;
    $banner->status = $request->status;
    $banner->save();
    Session::flash('sukses21','Banner Telah Diupdate');
    return redirect('/admin/banner');
}


      public function delete($id) {
        $banner = Banner::find($id);

        File::delete($banner->foto);
         $banner->delete();

        $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }
}
