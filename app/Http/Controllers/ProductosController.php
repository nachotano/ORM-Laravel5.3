<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Collective\Html\HtmlServiceProvider;
use Collective\Html\HtmlServiceProvider\Input;
use Session;
use Illuminate\Support\Facades\Auth;
/*use App\Classes\CartClass;*/
/* Model */
use App\Productos;
use App\Carrito;
use Carbon\Carbon;

class ProductosController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('articulos');
    }
      
  public $cart;

//Eloquent Insert Array with method save in a Model
    public function store($item_array_m)
    {
        //var_dump($item_array_m);
        $flight = new Carrito;

        $flight->sess_id = $item_array_m["sess_id"];     
        $flight->code = $item_array_m["code"];
        $flight->qty = $item_array_m["qty"];
        $flight->user_id = $item_array_m["user_id"];
        $flight->created_at = $item_array_m["created_at"];

        $flight->save();
    }
    
//borrando los datos de la session carro

public function vaciar()
    {
       Session::forget('carro');
       Session::regenerate();
       //Session::flush(); borra la session entera incluso 
       return redirect('articulos');
    }

//recupero la ultima cantidad de cada producto igresada en la base de datos 
public function get_old_qty($code,$sess_id,$qty)
    {
     
      $prods_qty = Carrito::where('code', '=', $code)->where('sess_id',$sess_id)->get(); 

      $valores = count($prods_qty);
     
        if($valores==0)
        {
             $old_qty = 0;
        }
        else
        {
             return $new_qty = $prods_qty[0]->qty+$qty;
        }
    }

//recupero el id del producto para usarlo en la registracion de la session
public function get_prod_id($code)
    {

    $prods_id = Carrito::where('code', '=', $code)->get(); 

        $valores = count($prods_id);

        if($valores==0)
        {
            $prods_id = 1;
        }
        else
        {
            foreach ($prods_id as  $value) 
            {    
                $value->id_cart;
            }
        }
    }

public function get_sess_id($code)
    {

         $prods_id = Carrito::where('code', '=', $code)->get(); 
         $valores = count($prods_id);

         if($valores==0)
         {
            $sess_id = Session::getId();
         }
         else{
           $prods_id[0]->sess_id;
         }
    }

public function check_prod($qty,$code,$id_prod,$precio)
    {          
         $user_id =  Auth::id();

         $si = $sess_id = Session::getId();
         //controlo si tengo producto con el $code Posteado
         $prods_db = Carrito::where('sess_id','=', $sess_id)->where('code', $code )->get();

         $productos_cart = json_decode($prods_db); //echo "Prod"; 
       
         //conto la cantidad de elementos en la DB 
         $row_cnt = count($productos_cart); //var_dump($prods_db); 

         

         $fecha_actual = Carbon::now()->toDateTimeString(); 
         //si no existe en el carro lo ingreso
            if ($row_cnt==0) 
            {  
                //recupero id usuario - session carro - id de session - id producto
                $user = Auth::user();
                $user_id =  Auth::id();
                $cart  = Session::get('carro');
                $sess_id = Session::getId();
                $sess_id2  =self::get_prod_id($code);
                //echo "ARRAY INDEX:";
                $sess_id2 =self::get_prod_id($code);
                //creo el array que sera memorizado en la primera session 1
                $item_array_n = array('sess_id' => $sess_id, 'code' => $code,'precio'=>$precio, 'qty'=>$qty,'user_id'=>$user_id);
                $carro=array();
                //creo la session
                Session::put('carro.'.strval($id_prod), $item_array_n);
                //salvo la session para globalizarla
                Session::save();
               // recupero la session de el id seleccionado
                $data = Session::get('carro.'.intval($sess_id2).'');            
                //inicializo la var $cart  
                $cart =Session::all();
               //Query - ingreso los datos en el carro el la tabla carrito (estos son los datos que sirven para estadisticas o sguimiento de ordenes de clientes).

/* NB: MOD ----> */      $item_array_m = array('sess_id' => $sess_id, 'code' => $code, 'qty'=>$qty,'user_id'=>$user_id,'created_at'=>$fecha_actual);
               
               // Carrito::insert(['sess_id' => $sess_id, 'code' => $code, 'qty'=>$qty,'user_id'=>$user_id,'created_at'=>$fecha_actual ])->save();

                self::store($item_array_m);
            }
            else
            {
                //si ya existe uno en el carro actualizo la cantidad 
                $sess_id2 =self::get_prod_id($code);;
                //Si la cantidad posteada es = 0 actualizo la qty en la db y borro ese producto de la session carro 
                if($qty==0)
                {
                    //Borro el producto de la session
                    Session::forget('carro.'.strval($id_prod));  
                    //Actualizo la Cantidad de productos en la DB
                     DB::table('carrito')
                            ->where('code', $code)
                            ->update(array('qty' => '0','updated_at'=>$fecha_actual )); 
                    //Borro el producto de la sesion carro
                    Session::forget('carro'.strval($id_prod));
                }
                else
                { 
                 //Actualizando la Cantidad
                   $sess_id = Session::getId();
                   //calculo la nueva cantidad para este producto
                   $new_qty = self::get_old_qty($code,$sess_id,$qty);
         
                   $cart=array();
                   $user_id =  Auth::id();

                   //ingreso los datos a la DB
                   $item_array_n = array('sess_id' => $sess_id, 'code' => $code,'precio'=>$precio, 'qty'=>$new_qty,'user_id'=>$user_id,'updated_at'=>$fecha_actual);
                   $sess_id2 = self::get_prod_id($code);

                   //Actualizo los datos de la session            
                   Session::put('carro.'.strval($id_prod), $item_array_n);

                   Session::save();
                   //inicializo la session     
                   $cart =Session::all();

                   // Fecha actual Carbon::now()->toDateTimeString() es el equivalente de $hoy = date("Y-m-d H:i:s");  
                   $fecha_actual = Carbon::now()->toDateTimeString(); 
                   $new_qty =  intval($new_qty);

                  //Query Update - Vieja forma $query = "UPDATE `laravel`.`carrito` SET  `qty` = '$new_qty' WHERE `code` = $code;";
                  //Query Update - Nueva forma Actualizo la nueva Cantidad 

//NB:MOD ------> DB::table('carrito')->where('code', $code)->where('sess_id', $sess_id)->update(array('qty' => $new_qty,'updated_at'=>$fecha_actual )); 

//Became:------>
Carrito::where('code', $code)->where('sess_id', $sess_id)->update(array('qty' => $new_qty,'updated_at'=>$fecha_actual));              
                }
            } 
    }


//Editando el Carro
public function edit_cart($qty_edit,$precio_edit,$code_edit,$id_prod_edit)
{  
    $fecha_actual = Carbon::now()->toDateTimeString(); 
    
   $sess_id_edit = Session::getId();

   $user_id_edit =  Auth::id();

   //Creo el Array de Editaciòn de Session 
   $item_array_edit = array('sess_id' => $sess_id_edit, 'code' => $code_edit,'precio'=>$precio_edit, 'qty'=>$qty_edit,'user_id'=>$user_id_edit,'updated_at'=>$fecha_actual);
   //Creo Session Cart Actualizando el array de el producto seleccionado
   if($qty_edit==0)
   {
    //Borro el producto de la session
    Session::forget('carro.'.strval($id_prod_edit));  
   }
   else
   {//lo actualizo
    Session::put('carro.'.strval($id_prod_edit), $item_array_edit); 
   }
    $cart =Session::all();
   //Update DB
   Carrito::where('code', $code_edit)->where('sess_id', $sess_id_edit)->update(array('qty' => $qty_edit,'updated_at'=>$fecha_actual));

    return redirect('articulos'); 
} 


public function all_products(Request $request)
    {  
    //mostrar productos utilizo Request que remplaza lo el POST // $qty = $_POST['quantity']; NB:: si lo usas todavia funciona lo dejo comentado para que puedan probar
        //muestro los productos en venta en la vista articulos 
        $results =DB::table('productos')->get();         

        if (isset($_POST['quantity'])) 
        {
            //Variables necesarias para el calculo total de los productos agregados al carro!          
             $qty = $request['quantity'];//  $qty = $_POST['quantity'];             
            //codigo producto
             $code = $request['code'];
            //id producto
             $id_prod= $request['id_prod'];
            //precio
             $precio= $request['precio'];
            //precio producto necesario para el calculo en la session carro almacenada         
            self::check_prod($qty,$code,$id_prod,$precio);
             $cart = Session::get('carro');        
            //si existe el carro lo envio junto con todos los productos en venta
            if(isset($cart))
                return view('articulos', array('res' => $results,'cart' => $cart));
        }
        elseif(isset($_POST['quantity_edit']))
        {
             $qty_edit = $request['quantity_edit'];             
             $code_edit = $request['code_edit'];
             $id_prod_edit= $request['id_prod_edit'];
             $precio_edit= $request['precio_edit'];
 
             self::edit_cart($qty_edit,$precio_edit,$code_edit,$id_prod_edit);
             $cart = Session::get('carro');        
             //si existe el carro lo envio junto con todos los productos en venta
             if(isset($cart))
                return view('articulos', array('res' => $results,'cart' => $cart));
        }
        else
        {
           return view('articulos', array('res' => $results));
        }
     
    }

}
