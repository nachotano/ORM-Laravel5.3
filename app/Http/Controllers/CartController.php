<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
class CartController extends Controller
{
 	public function usar()
	{ 
		//DB::getQueryLog();
	$users = DB::select('select * from users');			
	$user_id = Auth::id();
	//$username = Auth::user()->name;
	//$fecha_actual = Carbon::now()->toDateTimeString();  
echo 	"Usando".$qty = $_POST['quantity'];



//return view('articulos')->with(['result2'=>$qty]); 


	// $insertData = array('campos'=>$campos,'etiqueta'=>$etiqueta,'mod_valores' => $mod_valores,'mod_etiquetas' => $mod_etiquetas,'user_id' => $user_id,'nombre_user' => $username, 'impactado'=>$impactado, 'nombre_objeto'=>$nombre_objeto, 'cambio'=>$cambio, 'id_archivo'=>$id_archivo,'fecha'=>$fecha_actual);

	// $result = DB::table('cambios_log')->insert($insertData);
	// //DB::connection('mysql')->enableQueryLog();
	// $connection = new TestClass(); 
	// $connection->connect();
	// $query = "SELECT * FROM `cambios_log` where user_id='".$user_id."'";
	// $res=$connection->queryes($query);	
	// $connection->uploadfile($user_id,$id_archivo,$fecha_actual);
	

	// $connection1 = new TestClass();  
	// $connection1->connect();
	// $query1 = "SELECT MAX(fecha)as fecha  FROM `cambios_log` where user_id='".$user_id."'";
	// $res_fecha=$connection1->view_fecha($query1);
	// $only_max = $connection1->max_fecha;


	// $connection2 = new TestClass();  
	// $connection2->connect();
	// $query2 = "SELECT distinct(fecha) as fecha , id_archivo FROM dashboard.log_cambios_csv where user_id='".$user_id."';";
	// $res_csv=$connection2->queryes2($query2);


 //    return view('import')->with(['res'=>$res,'res_csv'=>$res_csv]);   
     
 //    return view('/import',array('user_id' => $user_id,'tag_impactado'=>$tag_impactado, 'impactado'=>$impactado, 'nombre_objeto'=>$nombre_objeto, 'cambio'=>$cambio, 'id_archivo'=>$id_archivo,'fecha_actual'=>$fecha_actual ));
	}	


	public function test(){

 $data = Session::all();
var_dump($data);
	}
}
