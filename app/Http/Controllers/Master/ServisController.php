<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Servis;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;

class ServisController extends Controller
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
        $servis = Servis::all();
        return Datatables::of($servis)
         ->addColumn('action', function ($servis) {
             $status=$servis->status;
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
        $servis = Servis::all();
         $settingweb = Settingweb::find('001');
    	return view('master.servis.servis',['servis' => $servis,'settingweb' => $settingweb]);
    }

     public function tambah(){
        $servis = Servis::all();
         $settingweb = Settingweb::find('001');
    	return view('master.servis.tambah_servis',['servis' => $servis,'settingweb' => $settingweb]);
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
        $path       = 'data_file/foto_servis/';
		$nama_file = $path.$file->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload =  $path;
        $file->move($tujuan_upload,$nama_file);
                
        Servis::create([
            'nama' => $request->nama,
            'ket' => $request->ket,
            'foto' => $nama_file,
            'status' => $request->status,
            'link' => $request->link,
            'alt_teks' => $request->alt_teks,
        ]);
        
         Session::flash('sukses','Service has been Created');
        return redirect('/admin/servis');
    }

     public function edit($id){
      $servis = Servis::find($id);
      $settingweb = Settingweb::find('001');
       return view('master.servis.edit_servis', ['servis' => $servis,'settingweb' => $settingweb]);
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

    $servis = Servis::find($id);

    if($request->file('foto') == "")
        {
            $servis->foto = $servis->foto;
        } 
        else
        {
            File::delete($servis->foto);
            $file       = $request->file('foto');
            $path       = 'data_file/foto_servis/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $servis->foto = $fileName;
        }
   
    
	$servis->nama = $request->nama;
	$servis->ket = $request->ket;
    $servis->link = $request->link;
    $servis->status = $request->status;
    $servis->alt_teks = $request->alt_teks;
    $servis->save();
    Session::flash('sukses21','Service has been Updated');
    return redirect('/admin/servis');
}

    public function delete($id) {
        $servis = Servis::find($id);

        File::delete($servis->foto);
         $servis->delete();

        $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }
    
}
