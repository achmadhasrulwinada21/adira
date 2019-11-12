<?php

namespace App\Http\Controllers\Artikel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Artikel\Artikel;
use App\Model\Artikel\V_artikel;
use App\Model\Artikel\Kategori;
use App\Model\Artikel\Tag;
use App\Model\Artikel\Artikel_tag;
use App\Model\Setup\Settingweb;
use DataTables;
use Session;
use File;
use App\Mail\AchmadEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ArtikelController extends Controller
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
        $v_artikel = DB::table('artikel') 
                    ->select(DB::raw('artikel.id,artikel.judul,artikel.isi_artikel,artikel.foto,artikel.id_kategori,kategori.kategori,artikel.file_artikel,artikel.keyword,artikel.language,artikel.artikel_parent,artikel.alt_teks'))
                    ->Join('kategori','artikel.id_kategori', '=', 'kategori.id')
                     ->get();
        return Datatables::of($v_artikel)
        ->addIndexColumn()
        ->make(true);
    }

     public function index(){
        $artikel = Artikel::all();
        $settingweb = Settingweb::find('001');
        return view('artikel.artikel',['artikel' => $artikel,'settingweb' => $settingweb]);
    }

     public function tambah(){
        $kategori = Kategori::all();
        $settingweb = Settingweb::find('001');
    	return view('artikel.tambah_artikel',['kategori' => $kategori,'settingweb' => $settingweb]);
  }

    public function insert(Request $request) {
        

    	$this->validate($request,[
            'judul' =>'required',
            'isi_artikel' =>'required',
            'foto' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'file_artikel'=>'file|mimes:pdf|max:2048',
            'id_kategori' => 'required',
            'keyword' => 'required',
            'alt_teks' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
         ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        $path       = 'data_file/foto_artikel/';
		$nama_file = $path.$file->getClientOriginalName();
        $request->foto=$nama_file;
      	// isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file/foto_artikel';
        $file->move($tujuan_upload,$nama_file);
        
        if($request->file('file_artikel') == "")
        {
            $nama_file2 =' ';
        }else{
          // menyimpan data file yang diupload ke variabel $file
        $file2 = $request->file('file_artikel');
        $path2       = 'data_file/file_artikel/';
		$nama_file2 = $path2.$file2->getClientOriginalName();
 
      	// isi dengan nama folder tempat kemana file diupload
		$tujuan_upload2 = 'data_file/file_artikel';
		$file2->move($tujuan_upload2,$nama_file2);
        }

        Artikel::create([
            'judul' => $request->judul,
            'isi_artikel' => $request->isi_artikel,
            'foto' => $nama_file,
            'file_artikel' => $nama_file2,
            'id_kategori' => $request->id_kategori,
            'keyword' => $request->keyword,
            'language' =>$request->language,
            'artikel_parent'=>$request->artikel_parent,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'alt_teks'=>$request->alt_teks,
            'status' => $request->status
        ]);

         $tabel_artikel = Artikel::orderBy('id', 'Asc')->get(); 
               foreach ($tabel_artikel as $tb_artikel) {
               $id_artikel = $tb_artikel->id;
                }
            
         $tag = strtolower($request->tag);  
         $tags = explode(',', $tag);
                 
        foreach ($tags as $tag) {

          $slug = Str::slug($tag, '-');
          $tagss = Tag::where('slug',$slug)->exists(); 

          if($tagss <> $tag) {

               $tagsave = new Tag();
               $tagsave->name =  $tag;
               $tagsave->slug = $slug;
               $tagsave->save();
           }           
           $tabel_tag = Tag::where('slug',$slug)->get();
              foreach ($tabel_tag as $tb_tag) {
               $id_tag = $tb_tag->id;
               }
            
               $artikel_tag = new Artikel_tag();
               $artikel_tag->id_artikel = $id_artikel;
               $artikel_tag->id_tag = $id_tag;
               $artikel_tag->save();
            }
            
          Session::flash('sukses','Artikel Telah Ditambahkan');
          return redirect('/admin/artikel');
    }

      public function edit($id){
      $artikel = Artikel::find($id);
      $settingweb = Settingweb::find('001');
      $kategori = Kategori::all();
      $artikel_tag= DB::table('artikel_tag') 
                    ->select(DB::raw('artikel_tag.id_artikel,artikel_tag.id_tag,tag.name,tag.slug'))
                    ->Join('tag','artikel_tag.id_tag', '=', 'tag.id')
                     ->where('artikel_tag.id_artikel','=',$id)
                     ->get();
     
    $name=array();
    foreach($artikel_tag as $a_tag){
        $name[]=$a_tag->name;
    }
    $tag= implode(', ', $name);   
                             
     return view('artikel.edit_artikel', ['artikel' => $artikel,'kategori' => $kategori,'settingweb' => $settingweb,'tag'=>$tag]);
    }
    
      public function update($id, Request $request){
           
         $tag = strtolower($request->tag);  
        //  $tag= str_replace(' ', ',', $tag1);
           
         $tags = explode(',', $tag);
          
         foreach ($tags as $tag) {

          $slug = Str::slug($tag, '-');
          $tagss = Tag::where('slug',$slug)->exists(); 

          if($tagss <> $tag) {

               $tagsave = new Tag();
               $tagsave->name =  $tag;
               $tagsave->slug = $slug;
               $tagsave->save();
           }           
           $tabel_tag = Tag::where('slug',$slug)->get();
              foreach ($tabel_tag as $tb_tag) {
               $id_tag = $tb_tag->id;
               }
       // Artikel_tag::updateOrCreate(['id_artikel' => $id], ['id_tag' => $id_tag]);
    $table = Artikel_tag::firstOrNew(['id_artikel' => $id], ['id_tag' => $id_tag]);
    $table->save();   
            }
                
    $this->validate($request,[
	    'judul' =>'required',
        'isi_artikel' =>'required',
        'foto' =>'file|image|mimes:jpeg,png,jpg|max:2048',
        'file_artikel'=>'file|mimes:pdf|max:2048',
        'id_kategori' => 'required',
        'keyword' => 'required',
        'alt_teks' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'required',
    ]);

    $artikel = Artikel::find($id);

              

    if($request->file('foto') == "")
        {
            $artikel->foto = $artikel->foto;
        } 
        else
        {
            File::delete($artikel->foto);
            $file       = $request->file('foto');
            $path       = 'data_file/foto_artikel/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('foto')->move($path, $fileName);
            $artikel->foto = $fileName;
        }

     if($request->file('file_artikel') == "")
        {
            $artikel->file_artikel = $artikel->file_artikel;
        } 
        else
        {
            File::delete($artikel->file_artikel);
            $file2       = $request->file('file_artikel');
            $path2       = 'data_file/file_artikel/';
            $fileName2   =  $path2.$file2->getClientOriginalName();
            $request->file('file_artikel')->move($path2, $fileName2);
            $artikel->file_artikel = $fileName2;
        }
    
    
    $artikel->alt_teks = $request->alt_teks;
    $artikel->meta_title = $request->meta_title;
    $artikel->meta_description = $request->meta_description;
    $artikel->judul = $request->judul;
	$artikel->isi_artikel = $request->isi_artikel;
    $artikel->id_kategori = $request->id_kategori;
    $artikel->keyword = $request->keyword;
    $artikel->status = $request->status;
    $artikel->save();
    Session::flash('sukses21','Artikel Telah Diupdate');
    return redirect('/admin/artikel');
}

     public function delete($id) {
        $artikel = Artikel::find($id);

        File::delete($artikel->foto);
        File::delete($artikel->file_artikel);
        $artikel->delete();

        $callback = [
            "message" => "Data has been Deleted",
            "code"   => 200
        ];

        return json_encode($callback, TRUE);
    }

     public function create_article($id){
        $settingweb = Settingweb::find('001');
        $artikel = Artikel::find($id);
        $kategori = Kategori::all();
       return view('artikel.create_en_article',['kategori' => $kategori,'artikel' =>$artikel,'settingweb'=>$settingweb]);
  }

}
