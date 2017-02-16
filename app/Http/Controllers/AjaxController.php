<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Collective\Html\HtmlServiceProvider;

use Session;

use Input;

use Response;

class AjaxController extends Controller
{

 
public function index(Request $request){
	   if(Request::ajax()) {
      $request = Input::all();
      print_r($request);die;
    }
}

	public function store(Request $request) {

   if(Request::ajax()) {
      $request = Input::all();
      print_r("HOLA"+$request);die;
    }
}



}
