<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setup\Settingweb;
use Illuminate\Support\Facades\DB;
use Session;
use File;

class SettingwebController extends Controller
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
        $settingweb = Settingweb::all();
        return Datatables::of($settingweb)
         ->addColumn('action', function ($settingweb) {
                $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$settingweb->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i>&nbspEdit</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$settingweb->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i>&nbspDelete</a></center>';
                      return $btn;
            }
        )
        ->addIndexColumn()
        ->make(true);
    }

    public function index(){
        $settingweb = Settingweb::find('001');
         return view('setup.settingweb',['settingweb' => $settingweb]);
    }

     public function perusahaan(){
        $settingweb = Settingweb::find('001');
         return view('setup.perusahaan',['settingweb' => $settingweb]);
    }

    public function sosmed(){
        $settingweb = Settingweb::find('001');
         return view('setup.sosmed',['settingweb' => $settingweb]);
    }

     public function show(){
		$settingweb = Settingweb::find('001');
        return view('layouts.index',['settingweb' => $settingweb]);
    }

     public function update(Request $request)
    {
          $this->validate($request,[
                'title' => 'required',
                'nm_web' =>'required',
                'link_web' => 'required',
                'logo_web' =>'file|image|mimes:jpeg,png,jpg|max:2048',
               ]);

        $settingweb = Settingweb::find($request->id);

     if($request->file('logo_web') == "")
        {
            $settingweb->logo_web = $settingweb->logo_web;
        } 
        else
        {
            File::delete($settingweb->logo_web);
            $file       = $request->file('logo_web');
            $path       = 'assets/logo_web/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('logo_web')->move($path, $fileName);
            $settingweb->logo_web = $fileName;
        }
          $settingweb->id = $request->id;
          $settingweb->title = $request->title;
          $settingweb->alt_teks = $request->alt_teks;
          $settingweb->nm_web = $request->nm_web;
          $settingweb->link_web = $request->link_web; 
          $settingweb->save();
         Session::flash('sukses','Setup Has Been Updated');
        return redirect('/admin/settingweb');

    }

    public function update_perusahaan(Request $request)
    {
          $this->validate($request,[
                'nm_perusahaan' => 'required',
                'alamat' =>'required',
                'no_telp' => 'required',
                'fax' =>'required',
                'copyright' => 'required',
               ]);

        $settingweb = Settingweb::find($request->id);

          $settingweb->id = $request->id;
          $settingweb->nm_perusahaan = $request->nm_perusahaan;
          $settingweb->alamat = $request->alamat;
          $settingweb->no_telp = $request->no_telp; 
          $settingweb->fax = $request->fax;
          $settingweb->email = $request->email;
          $settingweb->copyright = $request->copyright; 
          $settingweb->save();
         Session::flash('sukses21','Setup Has Been Updated');
        return redirect('/admin/settingweb');

    }

     public function update_sosmed(Request $request)
    {
          $this->validate($request,[
                'logo_sosmed1' =>'file|image|mimes:jpeg,png,jpg|max:2048',
                'link_sosmed1' => 'required',
                'logo_sosmed2' =>'file|image|mimes:jpeg,png,jpg|max:2048',
                'link_sosmed2' => 'required',
                'logo_sosmed3' =>'file|image|mimes:jpeg,png,jpg|max:2048',
                'link_sosmed3' => 'required',
               ]);

        $settingweb = Settingweb::find($request->id);

//logo facebook
     if($request->file('logo_sosmed1') == "")
        {
            $settingweb->logo_sosmed1 = $settingweb->logo_sosmed1;
        } 
        else
        {
            File::delete($settingweb->logo_sosmed1);
            $file       = $request->file('logo_sosmed1');
            $path       = 'data_file/logo_sosmed/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('logo_sosmed1')->move($path, $fileName);
            $settingweb->logo_sosmed1 = $fileName;
        }

//logo instagram
         if($request->file('logo_sosmed2') == "")
        {
            $settingweb->logo_sosmed2 = $settingweb->logo_sosmed2;
        } 
        else
        {
            File::delete($settingweb->logo_sosmed2);
            $file       = $request->file('logo_sosmed2');
            $path       = 'data_file/logo_sosmed/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('logo_sosmed2')->move($path, $fileName);
            $settingweb->logo_sosmed2 = $fileName;
        }

//logo twitter
         if($request->file('logo_sosmed3') == "")
        {
            $settingweb->logo_sosmed3 = $settingweb->logo_sosmed3;
        } 
        else
        {
            File::delete($settingweb->logo_sosmed3);
            $file       = $request->file('logo_sosmed3');
            $path       = 'data_file/logo_sosmed/';
            $fileName   =  $path.$file->getClientOriginalName();
            $request->file('logo_sosmed3')->move($path, $fileName);
            $settingweb->logo_sosmed3 = $fileName;
        }
          $settingweb->id = $request->id;
          $settingweb->link_sosmed1 = $request->link_sosmed1;
          $settingweb->link_sosmed2 = $request->link_sosmed2;
          $settingweb->link_sosmed3 = $request->link_sosmed3; 
          $settingweb->alt_teks_fb = $request->alt_teks_fb;
          $settingweb->alt_teks_ig = $request->alt_teks_ig;
          $settingweb->alt_teks_twit = $request->alt_teks_twit;
          $settingweb->save();
         Session::flash('sukses','Setup Has Been Updated');
        return redirect('/admin/settingweb');

    }

}
