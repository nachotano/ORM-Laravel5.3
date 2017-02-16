<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    //
      protected $table = "carrito";
      protected $sess_id = 'sess_id';
     
      protected  $fillable = array('id_cart', 'sess_id', 'code', 'qty', 'user_id','created_at','updated_at');
}
