<?php
require_once '../../model/conexion.php';
require_once '../../model/productos_model.php';
require_once '../../adodb5/adodb.inc.php';
require_once '../../model/enviarCorreo.php';
require_once '../../model/cerrarSesion.php';

require_once '../../model/carrito.php';
$mostrar = new mostrar();
$agregar = new  carrito();
$cerrarSesion = new cerrarSesion;


if (isset($_GET['opc'])) {
  $opc = $_GET['opc'];

  switch ($opc) {
    case '1': //mostrar Todos los productos
      {
        // echo 'el usuario' . $_SESSION['id_usuario'];
        if (isset($_SESSION['id_usuario'])) {
          $productos = $mostrar->mostrarTodosProductos();
          echo '
                    <div class="row">';
          foreach ($productos as $producto) {
            echo '
                            <div class="col-4">
                                <hr>
                                <h2><' . $producto['producto'] . '</h2>
                                <p>Precio:' . $producto['precio'] . '</p>
                                <p>Unidades en Stock:' . $producto['stock'] . '</p>
                                <p>Sobre el platillo: ' . $producto['descripcion'] . '</p>
                                <div class="photo">
                                    <img src="../assets/images/' . $producto['imagen'] . '" alt="">
                                </div>
                                <input type="button" class="btn btn-danger" value="AGREGAR" onclick="actualizarCarrito(' . $producto['id_producto'] . ')">
                                <div id="contador-' . $producto['id_producto'] . '">0</div>
                                <button onclick="aumentarContador(' . $producto['id_producto'] . ')">+</button>
                                <button onclick="disminuirContador(' . $producto['id_producto'] . ')">-</button>
                            </div>';
          }
          echo '   </div>';
        }
      }
      break;
    case '2': {
        if (isset($_SESSION['id_usuario'])) {

          $contador = $_GET['contador'];
          $id_p = $_GET['id_producto'];
          $contador = intval($contador);
          $id_p = intval($id_p);
          echo "El valor del contador es: " . $contador . "  producto=" . $id_p;
          $agregar->agregarCarrito($_SESSION['id_usuario'], $id_p, $contador);
        } else {
          echo "los valores no se ingresaron correctamente";
        }
      }


    case '3':
      $total = $agregar->mostrarTotal($_SESSION['id_usuario']);
      $productos = $agregar->obtenerCarrito($_SESSION['id_usuario']);
      foreach ($productos as $producto) {
        echo '<div class="panel-body">
                        <div class="row">
                            <div class="col-xs-2">
                                <img src="../assets/images/' . $producto['imagen'] . '" alt="Imagen del producto" width="300" height="200">
                            </div>
                            <div class="col-xs-4">
                                <p>ID Producto: ' . $producto['id_producto'] . '</p>
                            </div>
                            <div class="col-xs-6">
                                <div class="col-xs-6 text-right">
                                    <p>Producto: ' . $producto['producto'] . '</p>
                                    <p>Precio: $' . $producto['precio'] . '</p>
                                    <p>Cantidad: ' . $producto['cantidad'] . '</p>
                                    <p>SUBTOTAL: $' . $producto['subtotal'] . '</p>
                                </div>
                                <div class="col-xs-6">
                                <input type="button" class="btn btn-danger" value="ELIMINAR" onclick="borrarDeCarrito(' . $producto['id_producto'] . ')">

                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>';
      }
      echo '<div class="panel-footer">
            <div class="row text-center">
           
             <div id="paypal-button-container"></div>


                </div>';
                //  <input type="button" class="btn btn-danger" value="PAGAR" onclick="comprarCarrito()">

      $total = $agregar->mostrarTotal($_SESSION['id_usuario']);

      echo '<p>TOTAL $' . $total . '</p>
                    ';

      echo '
            </div>
        </div>';
      break;
    case 4: //borrar de carrito

      if (isset($_SESSION["id_usuario"])) {
        $producto = $_POST['id_producto'];
        $idUser = $_SESSION["id_usuario"];
        $agregar->eliminarElementoDelCarrito($idUser, $producto);
      } else {
        echo "El usuario no está definido";
      }
      break;
    case '12': ///parametros para paypal|
      $carrito = new Carrito(); // Asegúrate de que la clase Carrito esté definida
      $idUser = $_SESSION["id_usuario"];
      $productos = array();  // Un arreglo para almacenar la información de los productos
      $total = $carrito->mostrarTotal($_SESSION["id_usuario"]);
      // Imprime un único JSON que contiene tanto el total como la información de los productos
      echo json_encode(array('total' => $total));
      break;

    case 5: ////comprar carrito
      if (isset($_SESSION["id_usuario"])) {
        $id = $_POST['id'];
        $ticket = '';
        $ultimoUsuario = '';
        $productos = $agregar->obtenerCarrito($_SESSION['id_usuario']);
        $total = $agregar->mostrarTotal($_SESSION['id_usuario']);
        $ticket .= '<!DOCTYPE html>
                <html lang="es">
                
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <title>Recibo de Compra</title>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <style>
                        body {
                            font-family: sans-serif;
                            background-color: #f8f9fa;
                        }
                
                        #ticket {
                            width: 300px;
                            margin: 20px auto;
                            padding: 10px;
                            border: 1px solid #ccc;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            background-color: #fff;
                            color: #333;
                        }
                
                        h1 {
                            text-align: center;
                            color: #343a40;
                        }
                
                        .product {
                            display: flex;
                            align-items: center;
                            margin-bottom: 10px;
                            border-bottom: 1px solid #ccc;
                            padding-bottom: 10px;
                        }
                
                        .product img {
                            width: 50px;
                            height: 50px;
                            margin-right: 10px;
                            border-radius: 5px;
                        }
                
                        .product-info {
                            flex: 1;
                        }
                
                        .product-info p {
                            margin: 5px 0;
                        }
                
                        .btn-danger {
                            background-color: #dc3545;
                            border-color: #dc3545;
                            color: #fff;
                        }
                
                        .btn-danger:hover {
                            background-color: #c82333;
                            border-color: #bd2130;
                        }
                
                        #total {
                            text-align: right;
                            font-size: 18px;
                            font-weight: bold;
                            margin-top: 10px;
                            color: #28a745;
                        }
                    </style>
                </head>
                
                <body>
                <div class="container">
        <div class="logo">
            <img src="https://th.bing.com/th/id/OIG.S1AIE_jS9sbk4vvBGGlK?w=1024&h=1024&rs=1&pid=ImgDetMain" alt="Logo de Coppel">
        </div>

        <div class="datos-compra">
            <h2>Datos de la Compra</h2>
            <p>folio de transaccion='.$id.'
        </div>';
        foreach ($productos as $producto) {
          $ultimoUsuario = $producto['correo'];
          $ticket .= '
                    <div class="detalle">
                    <h2>Detalle de la Compra</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $producto['producto'] . '</td>
                                <td>' . $producto['cantidad'] . '</td>
                                <td>$' . $producto['precio'] . '</td>
                                <td>$' . $producto['subtotal'] . '</td>
                            </tr>
        
                        </tbody>
                    </table>
                </div>       
                    ';
        }



        $ticket .= ' 
          <div class="total">
          <p><strong>Total:</strong> $' . $total . '</p>
          </div>
          <div class="agradecimiento">
          <p>¡Gracias por tu compra!</p>
      </div>
  </div>

</body>
          ';

        $ticket .= '
                  
                </html>
                ';
        $correo = new MailerService();
        ///envia correo
        $correo->sendMailTicket($ultimoUsuario, $ticket);
        //echo $id;
        $agregar->comprarCarrito($_SESSION["id_usuario"],$id);
      } else {
        echo "inicia sesion";
      }


    case 6: //barra de tareas
      if (isset($_SESSION['id_usuario'])) {
        if ($_SESSION["id_rol"] == 1) { //admin
          echo '    <!--Barra de Navegacion-->
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand"><img src="../assets/images/Restlogocorr.png" height="60" alt=""></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                          <a class="nav-link" href="historialDeCompras.php">Historial <span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item active">
                            <a class="nav-link" href="./productos.php">Platillos<span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item active">
                            <a class="nav-link" href="./crearProductos.html">Agregar Platillo<span class="sr-only">(current)</span></a>
                          </li>

                          <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                              Más
                            </a>
                            <div class="dropdown-menu">
                            <a class="nav-link" href="./productos.php">Platillos<span class="sr-only">(current)</span></a>
                          </li> -->
                          <li class="nav-item">
                          <a class="nav-link" href="../controller/user/ctrlUser.php?opc=11">CERRAR SESION</a>
                          </li>

                          <li class="nav-item">
                          <a class="nav-link" href="./g.php">GRAFICA</a>
                          </li>

                          <li class="nav-item">
                          <a class="nav-link" href="actualizar.php">MODIFICAR</a>
                          </li>
                          <li class="nav-item">
                          <div class="carrito-container">
                          <a class="fa-solid fa-cart-shopping" id="carrito-btn" href="./carrito.php"><sup id="contador-value"></sup></a>
                      </div>
                          </li >
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                        </form>
                      </div>
                    </nav>';
        } else if ($_SESSION["id_rol"] == 2) { //usuario
          echo '    <!--Barra de Navegacion-->
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand"><img src="../assets/images/Restlogocorr.png" height="60" alt=""></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                            <a class="nav-link" href="historialDeCompras.php">Historial <span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item active">
                            <a class="nav-link" href="./productos.php">Platillos<span class="sr-only">(current)</span></a>
                          </li>

                          <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                              Más
                            </a>
                            <div class="dropdown-menu">
                          </li> -->
                          <li class="nav-item">
                            <a class="nav-link" href="../controller/user/ctrlUser.php?opc=11">CERRAR SESION</a>
                          </li>
                          <li class="nav-item">
                          <div class="carrito-container">
                          <a class="fa-solid fa-cart-shopping" id="carrito-btn" href="./carrito.php"><sup id="contador-value"></sup></a>
                      </div>
                          </li >
                        </ul>
                        <form class="form-inline my-2 my-lg-0">

                        </form>
                      </div>
                    </nav>';
        } else {
          echo '    <!--Barra de Navegacion-->
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand"><img src="./assets/images/Restlogocorr.png" height="60" alt=""></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                          </li>
                        

                          <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                              Más
                            </a>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="./vistas/login.php">Platillos</a>
                          </li> -->
                          <li class="nav-item">
                            <a class="nav-link" href="./vistas/nosotros.html">Sobre Nosotros</a>
                          </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                          <div>
                            <a href="./vistas/sign up.html" class="btn btn-outline-success">Sign Up</a>
                            <!--Se cree un btn para que nos lleve a otra ventana-->
                            <a href="./vistas/login.php" class="btn btn-outline-success">Login</a>
                            <!--Se cree un btn para que nos lleve a otra ventana-->
                          </div>
                        </form>
                      </div>
                    </nav>';
        }
      } else {
        echo '    <!--Barra de Navegacion-->
                <nav class="navbar navbar-expand-lg navbar-light">
                  <a class="navbar-brand"><img src="./assets/images/Restlogocorr.png" height="60" alt=""></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
            
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item active">
                        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="./vistas/login.php">Platillos<span class="sr-only">(current)</span></a>
                      </li>

                      <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                          Más
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="./vistas/login.php">Platillos</a>
                      </li> -->
                      <li class="nav-item">
                        <a class="nav-link" href="./vistas/nosotros.html">Sobre Nosotros</a>
                      </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                      <div>
                        <a href="./vistas/sign up.html" class="btn btn-outline-success">Sign Up</a>
                        <!--Se cree un btn para que nos lleve a otra ventana-->
                        <a href="./vistas/login.php" class="btn btn-outline-success">Login</a>
                        <!--Se cree un btn para que nos lleve a otra ventana-->
                      </div>
                    </form>
                  </div>
                </nav>';
      }
      break;
    case "8":
      $contador = $agregar->carritosContador($_SESSION['id_usuario']);
      echo $contador;
      break;
    case '11':
      $cerrarSesion->logoutUserById($_SESSION['id_usuario']);
      header('Location: ../../index.php');
      break;
  }
}
