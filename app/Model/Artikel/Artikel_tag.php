<?php

namespace App\Model\Artikel;

use Illuminate\Database\Eloquent\Model;

class Artikel_tag extends Model
{
     protected $table = 'artikel_tag';
     protected $fillable = ['id_artikel','id_tag'];
    public $timestamps = false;
}