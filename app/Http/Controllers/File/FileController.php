<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\File\File2;
use App\Model\File\Category;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;
use Illuminate\Support\Facades\DB;
class FileController extends Controller
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
        $file = DB::table('file') 
                    ->select(DB::raw('file.id,file.foto,file.ket,file.id_kategori,category_file.kategori'))
                    ->Join('category_file','file.id_kategori', '=', 'category_file.id')
                    ->get();  
        return Datatables::of($file)
         ->addColumn('action', function ($file) {
                $btn = '<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_edit'.$file->id.'" style="color:white;"><i class="fa fa-edit"></i>&nbspEdit</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$file->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i>&nbspDelete</a></center>';
                return $btn;
            })
        ->addIndexColumn()
        ->make(true);
    }

     public function index(){
        $file = File2::all();
        $kategori = Category::all();
        $settingweb = Settingweb::find('001');
    	return view('file.file',['file' => $file,'kategori' => $kategori,'settingweb' => $settingweb]);
    }

     public function insert(Request $request) {
               
    	$this->validate($request,[
            'foto' =>'required|max:2048',
            'ket' =>'required',
            'id_kategori' => 'required',
            'alt_teks' => 'required',
            ]);

            
        $file = $request->file('foto');
        $path       = 'file_upload/';
		$nama_file = $path.$file->getClientOriginalName();
       	$tujuan_upload =  $path;
        $file->move($tujuan_upload,$nama_file);
                

                        
        File2::create([
            'foto' => $nama_file,
            'ket' => $request->ket,
            'id_kategori' => $request->id_kategori,
            'alt_teks' => $request->alt_teks,
           ]);
         Session::flash('sukses','File Has Been Created');
        return redirect('/admin/file');
    }

      public function destroy($id)
    {
        $file = File2::find($id);
        File::delete($file->foto);
        $file->delete();

       $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }

     public function update($id, Request $request){

     $filess = File2::find($id);

    if($request->file('foto') == "")
        {
            $filess->foto = $filess->foto;
        } 
        else
        {
            File::delete($filess->foto);
            $file       = $request->file('foto');
            $path       = 'file_upload/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $filess->foto = $fileName;
        }  

    $filess->alt_teks = $request->alt_teks;
    $filess->ket = $request->ket;
	$filess->id_kategori = $request->id_kategori;
    $filess->save();
    Session::flash('sukses','File Has Been Updated');
    return redirect('/admin/file');
}

}
