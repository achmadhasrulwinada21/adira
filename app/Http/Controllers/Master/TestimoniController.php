<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Testimoni;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;

class TestimoniController extends Controller
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
        $testimoni = Testimoni::all();
        return Datatables::of($testimoni)
         ->addColumn('action', function ($testimoni) {
             $status=$testimoni->status;
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
        $testimoni = Testimoni::all();
         $settingweb = Settingweb::find('001');
    	return view('master.testimoni.testimoni',['testimoni' => $testimoni,'settingweb' => $settingweb]);
    }

     public function tambah(){
        $testimoni = Testimoni::all();
        $settingweb = Settingweb::find('001');
    	return view('master.testimoni.tambah_testimoni',['testimoni' => $testimoni,'settingweb' => $settingweb]);
  }
  public function insert(Request $request) {
               
    	$this->validate($request,[
            'nama' =>'required',
            'ket' =>'required',
            'foto' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
            'alt_teks' => 'required',
            ]);

         // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        $path       = 'data_file/foto_testimoni/';
		$nama_file = $path.$file->getClientOriginalName();
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload =  $path;
        $file->move($tujuan_upload,$nama_file);
                
        Testimoni::create([
            'nama' => $request->nama,
            'ket' => $request->ket,
            'foto' => $nama_file,
            'status' => $request->status,
            'alt_teks' => $request->alt_teks,
            ]);
        
         Session::flash('sukses','Testimony Has Been Created');
        return redirect('/admin/testimoni');
    }

    public function edit($id){
      $testimoni = Testimoni::find($id);
      $settingweb = Settingweb::find('001');
       return view('master.testimoni.edit_testimoni', ['testimoni' => $testimoni,'settingweb' => $settingweb]);
    }

     public function update($id, Request $request){
    $this->validate($request,[
	    'nama' =>'required',
        'ket' =>'required',
        'foto' =>'file|image|mimes:jpeg,png,jpg|max:2048',
        'status' => 'required',
        'alt_teks' => 'required',
    ]);

    $testimoni = Testimoni::find($id);

    if($request->file('foto') == "")
        {
            $testimoni->foto = $testimoni->foto;
        } 
        else
        {
            File::delete($testimoni->foto);
            $file       = $request->file('foto');
            $path       = 'data_file/foto_testimoni/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $testimoni->foto = $fileName;
        }
   
    
	$testimoni->nama = $request->nama;
	$testimoni->ket = $request->ket;
    $testimoni->status = $request->status;
    $testimoni->alt_teks = $request->alt_teks;
    $testimoni->save();
    Session::flash('sukses21','Testimony Has Been Updated');
    return redirect('/admin/testimoni');
}

    public function delete($id) {
        $testimoni = Testimoni::find($id);

        File::delete($testimoni->foto);
         $testimoni->delete();

        $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }
}
