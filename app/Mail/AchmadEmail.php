<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB; 

class AchmadEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    
    public function __construct($request)
    {
          $this->request=$request;   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
           
     $sw = DB::table('settingweb')->where('kode', '001')->first(); 
         
       return $this->from($sw->email)
                   ->subject('Selamat Datang di Website Adira Company')
                   ->view('artikel.email')
                   ->with(
                    [
                        'nama' => 'Adira',
                        'website' => 'www.adira.com',
                                               
                     ]);
    }
}
