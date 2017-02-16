<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <!-- Required files IO Example 02-12-2016-->
 <link rel="stylesheet" href="css/jquery-ui.css">  
   <style>

    .modalDialog {
        position: fixed;
        font-family: Arial, Helvetica, sans-serif;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.8);
        z-index: 99999;
        opacity:0;
        -webkit-transition: opacity 400ms ease-in;
        -moz-transition: opacity 400ms ease-in;
        transition: opacity 400ms ease-in;
        pointer-events: none;
    }

    .modalDialog:target {
        opacity:1;
        pointer-events: auto;
    }

    .modalDialog > div {
        width: 400px;
        position: relative;
        margin: 10% auto;
        padding: 5px 20px 13px 20px;
        border-radius: 10px;
        background: #fff;
        background: -moz-linear-gradient(#fff, #999);
        background: -webkit-linear-gradient(#fff, #999);
        background: -o-linear-gradient(#fff, #999);
    }

    .close {
        background: #FF0000 !important;
        color: #FFFFFF;
        line-height: 25px;
        position: absolute;
        right: -12px;
        text-align: center;
        top: -10px;
        width: 24px;
        text-decoration: none;
        font-weight: bold;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 12px;
        -moz-box-shadow: 1px 1px 3px #000;
        -webkit-box-shadow: 1px 1px 3px #000;
        box-shadow: 1px 1px 3px #000;
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #FF0000 ;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: 1 !important;
    }


 
.close:hover { 
        background: #FF0000; 
    }

.smimg img{
        text-align: left;
        width:auto;
        height:170px !important;
}

.center {
        width: 150px;
        margin: 40px auto;
}
.form-control {  
        height:28px !important;
        border:0px !important;
}

h3 {
        padding-left: 15px !important;         
        margin-top: 5px !important; 
        font-weight: 500 !important;
}
    </style>

<body>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
 <link href="css/shop-homepage.css" rel="stylesheet">

      
@yield('content')

<script src="js/jquery.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script>
 jQuery(document).ready(function(){

// Ago un loop que sera el espejo de el foreach echo an la pagina articulos.blade.php  para apuntar a todos los quantity1...2..3..4 etc.
 $( ".modalDialog" ).each(function( i ) {
    var lop = i+1;

//incrementando campo input de uno
$('.qtyplus'+lop+'').click(function(e){
                // stop
                e.preventDefault();
                // Recupero el nombre de el field clickado
                fieldName = $(this).attr('field');
                // Recupero estes valor
                var currentVal = parseInt($('input[name='+fieldName+']').val());
                // Si el valore es diferente a undefined == idefinido
                if (!isNaN(currentVal)) {
                    // Incremento de uno el valor actual 
                   $('input[name='+fieldName+']').val(currentVal + 1);
                    var x =$('input[name='+fieldName+']').val();
                    
                    //asigno el valor x para cada quantity de forma que seteo el campo value por cada click sobre el boton qtyplus
                    var q = "#quantity"+lop;
                    $(q).attr("value", x );
                   
                } else {
                    // si es indefinido lo seteo como zero 
                    $('input[name='+fieldName+']').val(0);
                }
                });            

// El qty minus es igual pero incrementa en negativo --
$(".qtyminus").click(function(e) {
            
                e.preventDefault();
            
                fieldName = $(this).attr('field');
            
                var currentVal = parseInt($('input[name='+fieldName+']').val());

                if (!isNaN(currentVal) && currentVal > 0) {
                    // Decremento el valor actual
                    $('input[name='+fieldName+']').val(currentVal - 1);
                    var x =$('input[name='+fieldName+']').val();

                    //asigno el valor x para cada quantity de forma que seteo el campo value por cada click sobre el boton qtyplus
                    var q = "#quantity"+lop;
                    $(q).attr("value", x );

                } else {
                    // si es indefinido lo seteo como zero 
                    $('input[name='+fieldName+']').val(0);
                }
            }); 
    });
});

</script> 
</body>
</html>