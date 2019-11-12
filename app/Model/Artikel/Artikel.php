<?php

namespace App\Model\Artikel;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $fillable = ['judul','isi_artikel','foto','id_kategori','keyword','file_artikel','artikel_parent','language','alt_teks','meta_title','meta_description','status'];

     public function kategori(){
    	return $this->hasMany('App\Model\Artikel\Kategori');
    }
}
