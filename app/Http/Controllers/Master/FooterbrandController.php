<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Footerbrand;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;

class FooterbrandController extends Controller
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
        $footerbrand = Footerbrand::all();
        return Datatables::of($footerbrand)
         ->addColumn('action', function ($footerbrand) {
             $status=$footerbrand->status;
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
        $footerbrand = Footerbrand::all();
        $settingweb = Settingweb::find('001');
    	return view('master.footer_brand.footer_brand',['footerbrand' => $footerbrand,'settingweb' => $settingweb]);
    }

     public function tambah(){
        $footerbrand = Footerbrand::all();
       $settingweb = Settingweb::find('001');
    	return view('master.footer_brand.tambah_footerbrand',['footerbrand' => $footerbrand,'settingweb' => $settingweb]);
  }

  public function insert(Request $request) {
               
    	$this->validate($request,[
            'nama' =>'required',
            'ket' =>'required',
            'foto' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
            'link' => 'required',
            'alt_teks' => 'required',
         ]);

         // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        $path       = 'data_file/foto_footerbrand/';
		$nama_file = $path.$file->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload =  $path;
        $file->move($tujuan_upload,$nama_file);
                
        Footerbrand::create([
            'nama' => $request->nama,
            'ket' => $request->ket,
            'foto' => $nama_file,
            'status' => $request->status,
            'link' => $request->link,
            'alt_teks' => $request->alt_teks,
        ]);
        
         Session::flash('sukses','Data Telah Ditambahkan');
        return redirect('/admin/footerbrand');
    }

    public function edit($id){
      $footerbrand = Footerbrand::find($id);
      $settingweb = Settingweb::find('001');
       return view('master.footer_brand.edit_footerbrand', ['footerbrand' => $footerbrand,'settingweb' => $settingweb]);
    }

     public function update($id, Request $request){
    $this->validate($request,[
	    'nama' =>'required',
        'ket' =>'required',
        'foto' =>'file|image|mimes:jpeg,png,jpg|max:2048',
        'link' => 'required',
        'status' => 'required',
        'alt_teks' => 'required',
    ]);

    $footerbrand = Footerbrand::find($id);

    if($request->file('foto') == "")
        {
            $footerbrand->foto = $footerbrand->foto;
        } 
        else
        {
            File::delete($footerbrand->foto);
            $file       = $request->file('foto');
            $path       = 'data_file/foto_footerbrand/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $footerbrand->foto = $fileName;
        }
   
    
	$footerbrand->nama = $request->nama;
	$footerbrand->ket = $request->ket;
    $footerbrand->link = $request->link;
    $footerbrand->status = $request->status;
    $footerbrand->alt_teks = $request->alt_teks;
    $footerbrand->save();
    Session::flash('sukses21','Data Telah Diupdate');
    return redirect('/admin/footerbrand');
}


     public function delete($id) {
        $footerbrand = Footerbrand::find($id);

        File::delete($footerbrand->foto);
         $footerbrand->delete();

        $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }
}
