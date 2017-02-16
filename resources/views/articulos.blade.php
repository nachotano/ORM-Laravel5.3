@extends('layouts.principal')

@section('title', 'Page Title')
<!-- Required files IO Example 02-12-2016-->  
@section('sidebar')
    @parent
   
    @stop

@section('content')

<!--Mostrando el contenido del Carro --> 

<link rel="stylesheet" type="text/css" href="css/io_style.css">

<?php 

function get_fotos_productos($code)
{

    $fotos = DB::table('productos')->where('code','=',$code)->get();

    foreach ($fotos as $foto){
      $foto='<img src="img/productos/big/'.$foto->foto.'" width="50" alt="">';
      echo  $foto;
    } 
}
function show_button_edit($code)
{
         $user_id =  Auth::id();

         $sess_id = Session::getId();
   
         $result = DB::table('carrito')->where('code',$code)->where('sess_id',$sess_id)->where('user_id',$user_id)->distinct()->get();
       
        foreach ($result as $key => $value)
        {
            //echo $value->sess_id;
            $n=$value->code;
            if ($value->sess_id == $sess_id ) { 
                  echo $button= '<a target="_self" href="#openModaly'.$n.'" class="btn btn btn-warning">Edit Cart <span class="glyphicon glyphicon-pencil"></span>
                                    </a>';
             }
             else
             {
                echo "no";
             }
           
        }
    
    
}

$cart = Session::get('carro');
//si existe la session carro la muestro
    if(isset($cart)){

        $total_prod=array();
        $total_qty=array();
        foreach ($cart as $key => $value)
        {             
            $sess_id= $value["sess_id"];
            $code = $value["code"];
            $user_id = $value["user_id"]; 
            show_button_edit($sess_id,$user_id,$code);
            $value["qty"];
            $total_qty[$key]=$value["qty"];
            $total_prod[$key] = $value["precio"]*$value["qty"];
            $total_prod[$key];     
        }

//total de productos
     $total_prods = 0;
     foreach ($total_qty as  $v){
         $total_prods+=$v;
      }
//Calculando el total del carro
     $total = 0;
     foreach ($total_prod as  $v){
         $total+=$v;
      }
       "Costo Total:".$total;
       "<br>";
       "En el Carro".$total_prods;
}
//carro vacio
else{
 $total_prods=0;
}
 
 ?>
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">IO CART</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ asset('/home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ asset('/articulos') }}">Productos</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>                 
                </ul>
        <!-- DropDown Div Carro -->
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-shopping-cart"></span> <?php if(isset($total_prods) && $total_prods !== 0) echo "<font class='verdes'>En el Carro </font>".$total_prods;else echo "<font class='rojos'>En el Carro ".$total_prods."</font>"; ?><span class="caret"></span></a>
                      
                      <ul class="dropdown-menu dropdown-cart" role="menu">
                        <?php 
                        $id_prod=3;
                        if(isset($cart)){

                            foreach ($cart as $key => $value) {
                                $code = $value["code"];
                                      $total_prod[$key] = $value["precio"]*$value["qty"];
                                //echo "Precio Total para este producto:".$total_prod[$key];----->
                                echo '                          
                                <li>
                                  <span class="item">
                                    <span class="item-left">
                                     
                                     '. get_fotos_productos($code).'        
                                        <span class="item-info">
                                            <span>Codigo :'.$value["code"].'</span>
                                            <span>Cantidad : '.$value["qty"].'</span>
                                            <span>Total: ARS '.number_format($total_prod[$key],2).'</span>            
                                        </span>
                                    </span>
                                    <span class="item-right">
                                        <button class="btn btn-xs btn-danger pull-right">x</button>
                                    </span>
                                </span>
                                </li>
                                ';                                
                                }                            
                            $divider = true;
                        }

                        // Mostrando productos en la session Carro -->                         
                        if(isset($divider) &&  $divider==1)
                        {
                             echo '<li class="divider"></li>
                             <li>';
                             echo "Costo Total: ARS ".number_format($total,2);
                             echo '</li>
                             <li><a class="text-center" href="">View Cart</a></li>
                            ';
                                
                        }
                        else
                        {                          
                            echo'                          
                             <li><a class="text-center" href=""><font class="rojos">Carro Vacio </FONT></a></li>
                            ';
                        } 
                        ?> 
                          </ul>      
                        <li>
                    </ul>            

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <p class="lead">Categorias</p><a href="{{ asset('/articulos/vaciar') }}"> Vaciar Carro  <span class="glyphicon glyphicon-shopping-cart"></span></a><br>
                 <div class="list-group">
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row carousel-holder">
                <div class="row">
                    @foreach ($res as $k=>$prod)
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="img/productos/big/{{ $prod->foto }}" alt="">
                                <div class="caption">
                                    <h4 class="pull-right">$ARS {{ number_format($prod->precio,2) }}</h4>
                                    <h4><a href="#">{{ ucfirst($prod->nombre_prod) }}</a>
                                    </h4>
                                    <p>{{ ucfirst($prod->descr_prod) }} </p>
                                    <a target="_self" href="#openModal{{$k}}" class="btn btn-primary">Add to Cart 
                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                    </a>
                                        <!-- Show edit button if qty>0 -->
                                        {{ show_button_edit($prod->code)   }}
       
                                </div>
                                <div class="ratings">
                                    <p class="pull-right">15 reviews</p>
                                    <p>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!--Creando una ventana Modal ADD CART para cada elemento -->
                        <div id="openModal{{$k}}" field="{{ $prod->id }}" class="modalDialog">
                            <div>
                                <div  class="smimg">
                                    <img src="img/productos/big/{{ $prod->foto }}" alt="">
                                        <form id='myform{{ $prod->id }}' method='POST' action="{{ asset('/articulos') }}">
                                        {{ csrf_field() }}
                                        <input type='text'  class="id_prod" name='id_prod' value='{{ $prod->id }}'  />
                                        <input type='hidden'   name='nombre_prod' value='{{ $prod->nombre_prod }}'  />        
                                        <input type='hidden'   name='code' value='{{ $prod->code }}'  />                                   
                                        <input type='hidden'   name='precio' value='{{ $prod->precio }}'  />
                                            <div class="input-group center">
                                                    <span class="input-group-btn glyphicon glyphicon-minus">
                                                        <button type='button' value='-' class='btn btn-danger btn-number qtyminus' data-type="minus" field='quantity'><span class="glyphicon glyphicon-minus"></span>
                                                        </button>
                                                    </span>
                                                          <input type='text'  id="quantity{{ $prod->id }}" name='quantity' value="0" class='form-control input-number qty' />
                                                     <span class="input-group-btn glyphicon glyphicon-minus">+
                                                        <button type='button' value='' class='btn btn-success btn-number qtyplus{{ $prod->id }}' data-type="minus" field='quantity'><span class="glyphicon glyphicon-plus"></span></button>
                                                    </span>
                                            </div>
                                            <div class="cart_button btn btn-success btn-block">Add  to Cart</div>
                                            
                                             <button type="submit" class="bott" class="btn btn-info" name="submit">Enviar</button>
                                        </form>
                                    <a href="{{ asset('/articulos') }}" title="Close" class="close">X</a>
                                    </div>
                            </div>
                        </div>
                         <!--Creando una ventana Modal Edit CART para cada elemento -->
                        <div id="openModaly{{$prod->code}}" field="{{ $prod->id }}" class="modalDialog">
                            <div>
                                <div  class="smimg">
                                    <img src="img/productos/big/{{ $prod->foto }}" alt="">
                                        <form id='myform{{ $prod->id }}' method='POST' action="{{ asset('/articulos') }}">
                                        {{ csrf_field() }}
                                        <input type='text'  class="id_prod" name='id_prod_edit' value='{{ $prod->id }}'  />
                                        <input type='hidden'   name='nombre_prod' value='{{ $prod->nombre_prod }}'  />        
                                        <input type='hidden'   name='code_edit' value='{{ $prod->code }}'  />                                   
                                        <input type='hidden'   name='precio_edit' value='{{ $prod->precio }}'  />
                                            <div class="input-group center">
                                                    <span class="input-group-btn glyphicon glyphicon-minus">
                                                        <button type='button' value='-' class='btn btn-danger btn-number qtyminus' data-type="minus" field='quantity_edit'><span class="glyphicon glyphicon-minus"></span>
                                                        </button>
                                                    </span>
                                                          <input type='text'  id="quantity{{ $prod->id }}" name='quantity_edit' value="0" class='form-control input-number qty' />
                                                     <span class="input-group-btn glyphicon glyphicon-minus">+
                                                        <button type='button' value='' class='btn btn-success btn-number qtyplus{{ $prod->id }}' data-type="minus" field='quantity_edit'><span class="glyphicon glyphicon-plus"></span></button>
                                                    </span>
                                            </div>
                                            <div class="cart_button btn btn-success btn-block">Edit Cart</div>
                                            
                                             <button type="submit" class="bott" class="btn btn-info" name="submit">Enviar</button>
                                        </form>
                                    <a href="{{ asset('/articulos') }}" title="Close" class="close">X</a>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                 </div>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <div class="container">
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2017</p>
                </div>
            </div>
        </footer>
    </div>
 

<script src="js/jquery.js"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script type="text/javascript">
 
$(document).ready(function()
{

var numItems = $('.modalDialog').length;
//alert(numItems);

$( ".bott" ).click(function() {
  $( "#myform1" ).submit();
});


//$.each(numItems)


});

// });
</script>
@endsection