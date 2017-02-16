<?php   
namespace App\Classes;
class CartClass {
	
public $db_name = 'laravel'; 
public $db_user = 'root'; 
public $db_pass = 'Ignazio01!'; 
public $db_host = 'localhost'; 
public $connect_db;
	protected $myconn;
	protected $conn;
	public $pass;
public $result2;	
	// Open a connect to the database.
	// Make sure this is called on every page that needs to use the database.
	
public function connect() { 
     
        $this->connect_db = mysqli_connect( $this->db_host, $this->db_user, $this->db_pass, $this->db_name ); 
        echo "ok!";
        
    } 

public function show_cart(){
	echo "<br>En el Carrito:<br>";
	//var_dump($_SESSION['carro']);
	var_dump($_SESSION['carro']);
	//var_dump($_SESSION['carro'][3]);
}

public function ins_prod(){
 			
 echo $query = "SELECT count(sess_id) as sess FROM laravel.carrito;";
 $result = mysqli_query ($this->connect_db, $query);
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       echo   "TOT SESS".$count = $row["sess"];
   }  

	echo "ingresar producto;";
 
	//echo $count = count($_SESSION['carro']);
	echo "SuMO" .$count = $count+1;
	echo "INCRE".$incre_sess = $count++;
	
	//Array to follow session
		$item_array = array('nombre_prod' => $_POST["nombre_prod"],'code' => $_POST["code"], 'qty' => $_POST["quantity"]);


		//var_dump($item_array);
	//creating session content	
		$cart=array();
		$session_in = $_SESSION['session_in'] = $incre_sess;  
	    $cart = $_SESSION['carro'][$incre_sess]=$item_array;

	   //var_dump($cart);
	    //return "CaRRO!-->";
	    

	//Array to reg v into DB
		$item_array = array('code' => $_POST["code"], 'qty' => $_POST["quantity"]);
		
		$columns = implode(", ",array_keys($item_array));
		 
		$aValues = array();
	// Don't forget to protect against SQL injection :)
	foreach($item_array as $row => $val){
		    $aValues[] = $val;
		}
		var_dump($aValues);

		$db = $this->connect_db;		
		echo $query = "INSERT INTO `laravel`.`carrito`(id_cart,sess_id,$columns) VALUES ('','".$incre_sess."','".implode("','",$aValues)."');";
		$result = mysqli_query ($this->connect_db, $query);
		self::show_cart();
}


public function check_prod($query){

	 $db = $this->connect_db;
	 //$result = $db->query($query);

	 $result = mysqli_query ($this->connect_db, $query);
	 $row_cnt=mysqli_num_rows($result);

if ($row_cnt==0) 
{
		echo "no existe en el carro!";
		self::ins_prod();
}
else{
		echo "Ya tienes uno en el carro";

		$row = $result->fetch_array(MYSQLI_ASSOC);
		$sess_id = $row["sess_id"];
		$codigo = $row["code"];
		$old_qty = $row["qty"];

		//***Update old product quantity if exist in cart ***//
		echo "Acualiza SESS_ID".$sess_id."<br>";
		if($_POST["quantity"]==0){

		//Actualizo la Cantidad de productos en la DB
        echo $query = "UPDATE `laravel`.`carrito` SET  `qty` = '0' WHERE `sess_id` = $sess_id;";
        echo  $result = $db->query($query);

        //borro el producto de la session
        unset($_SESSION['carro'][$sess_id]);

		}else{

			echo $query = "SELECT * FROM laravel.carrito where sess_id ='$sess_id' ;";
			$result = $db->query($query);
			$item_arrayc=array();
		      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		       $qtyin = $row["qty"];
		   } 
		   $_SESSION['carro']=array();
 			echo "Old qty".$old_qty = $qtyin;
			self::show_cart();
			//echo "Old qty".$old_qty = $_SESSION['carro'][$sess_id]["quantity"];
		    echo "New qty".$new_qty = $old_qty + $_POST["quantity"];	
		//Actualizo la Cantidad de productos en el carro 

	    $item_array_n = array('nombre_prod' =>  $_POST["nombre_prod"],'codigo' => $codigo,'qty' => $new_qty);
		$cart = $_SESSION['carro'][$sess_id] = $item_array_n;
		\Session::set('carro', $cart);
		 
		//Actualizo la Cantidad de productos en la DB
        echo $query = "UPDATE `laravel`.`carrito` SET  `qty` = '$new_qty' WHERE `sess_id` = $sess_id;";
        echo  $result = $db->query($query);
		//muestro el contenido de el carro
		}	  	



		self::show_cart();
	}

	}





}
?>
