<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/AdministradorDAO.php';
    include_once 'modelo/ProductoDAO.php';
    include_once 'modelo/PedidoDAO.php';

    class adminController{
        
        public function solicitudCrearProducto(){

            include 'vistas/header.php';
            include 'vistas/panelCrearProducto.php';
            include 'vistas/footer.php';
        }

        public function crearProducto() {

            if (isset($_POST['agregar_producto'])) {

                $usuario_id = $_SESSION ['usuario_id'];

                $nombre = $_POST['nombre'];
                $categoria_producto = $_POST['categoria_producto'];
                $sabor = $_POST['sabor'];
                $calorias = $_POST['calorias'];
                $precio_sin_editar = $_POST['precio'];
                // Eliminaremos todos los carácteres que haya introducido el usuario menos números, comas o puntos:
                $precio_sin_editar = preg_replace("/[^0-9.,]/", "", $precio_sin_editar);
                // Reemplazaremos la coma por un punto:
                $precio_sin_editar = str_replace(',', '.', $precio_sin_editar);
                // Convertiremos el número a decimal:
                $precio = floatval($precio_sin_editar);
                $disponibilidad = $_POST['disponibilidad'];
                $stock = $_POST['stock'];
                $ingredientes = $_POST['ingredientes'];
                $destacado = $_POST['destacado'];
                $password = $_POST['password'];
                $imagen = $_FILES['imagen']['name'];
                $imagen_tmp = $_FILES['imagen']['tmp_name'];

                $valoracion = $_FILES['valoracion']['name'];
                $valoracion_tmp = $_FILES['valoracion']['tmp_name'];

                $ruta_imagen = "assets/imagenes/productos/nuevo/" . $imagen;
                $ruta_valoracion = "assets/imagenes/iconos/valoraciones/" . $valoracion;

                move_uploaded_file($imagen_tmp, $ruta_imagen);
                move_uploaded_file($valoracion_tmp, $ruta_valoracion);
    
                // Obtendremos la contraseña del cliente en la base de datos mediante la llamada del método que se encarga de recuperarla:
                $contrasena_almacenada = AdministradorDAO::obtenerPasswordAdmin($usuario_id);

                if ($contrasena_almacenada !== null && $password == $contrasena_almacenada) {

                    $productoDAO = new ProductoDAO();
                    
                    $productoDAO->agregarProducto($usuario_id, $categoria_producto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado,  $ruta_imagen, $ruta_valoracion,);

                    $mensaje_acierto = "¡Producto agregado correctamente!";
                    include 'vistas/header.php';
                    include 'vistas/panelCrearProducto.php';
                    include 'vistas/footer.php';

                }else {

                    /* Si la contraseña indicada no coincide con la guardada en la base de datos, le mostraremos un mensaje de error por pantalla y redirigiremos al cliente a
                    la misma página para que pueda volver a intentarlo: */ 
                        
                    // Mostrar mensaje de contraseña incorrecta
                    $mensaje_error = "Tu contraseña no es correcta.";
                    include 'vistas/header.php';
                    include 'vistas/panelCrearProducto.php';
                    include 'vistas/footer.php';
                }
            }
        }

        public function solicitudGestionarProductos() {

            $AllProductos = ProductoDAO::getAllProducts();
        
            include 'vistas/header.php';
            include 'vistas/panelGestionarProductos.php';
            include 'vistas/footer.php';
        }

        public function gestionarProducto() {
        
            if (isset($_POST['modificar'])) {

                $idProducto = $_POST['modificar'];
                $this->modificarProducto($idProducto);

            } elseif (isset($_POST['eliminar'])) {

                $idProducto = $_POST['eliminar'];
                $this->eliminarProducto($idProducto);
                
            } 
        }
        
        public function modificarProducto($idProducto) {
            
            $productoDAO = new ProductoDAO();
            $productoActual = $productoDAO::obtenerProductoByID($idProducto);
        
            include 'vistas/header.php';
            include 'vistas/panelModificarProducto.php';
            include 'vistas/footer.php';
        }

        public function eliminarProducto($idProducto) {

            $productoDAO = new ProductoDAO();
            $productoActual = $productoDAO::obtenerProductoByID($idProducto);

            include 'vistas/header.php';
            include 'vistas/panelEliminarProducto.php';
            include 'vistas/footer.php';
        }

        public function eliminarProductoSeleccionado(){

            $id_producto = $_SESSION ['productoActual']->getIdProducto();
            $productoActual = ProductoDAO::obtenerProductoByID($id_producto);

            if (isset($_POST['eliminar'])) {

                if ($productoActual) {

                    $idProducto = $_SESSION['productoActual']->getIdProducto();
                    ProductoDAO::eliminarProducto($id_producto);
                    header("Location:".url."?controller=admin&action=solicitudGestionarProductos");
                }

            } else {

                header("Location:".url."?controller=admin&action=solicitudGestionarProductos");
            }
        }

        public function actualizarProductoSeleccionado() {

            $id_producto = $_SESSION ['productoActual']->getIdProducto();
            $usuario_id = $_SESSION['usuario_id'];
            $productoActual = ProductoDAO::obtenerProductoByID($id_producto);

            if ($productoActual) {
                
                if (isset($_POST['modificar_producto'])) {

                    $idProducto = $_SESSION['productoActual']->getIdProducto();
                    $nombre = $_POST['nombre'];
                    $sabor = $_POST['sabor'];
                    $valor_energetico = $_POST['valor_energetico'];
                    $precio = $_POST['precio'];
                    $disponibilidad = $_POST['disponibilidad'];
                    $stock = $_POST['stock'];
                    $ingredientes = $_POST['ingredientes'];
                    $producto_destacado = $_POST['producto_destacado'];
                    $password = $_POST['password'];

                    $contrasena_almacenada = AdministradorDAO::obtenerPasswordAdmin($usuario_id);
            
                    if ($password == $contrasena_almacenada) {

                        ProductoDAO::actualizarProducto($idProducto, $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $ingredientes, $producto_destacado);
                        // Volvemos a cargar el producto modificado:
                        $productoActual = ProductoDAO::obtenerProductoByID($id_producto);
                        $mensaje_acierto = "¡El producto se ha modificado correctamente!";
                        include 'vistas/header.php';
                        include 'vistas/panelModificarProducto.php';
                        include 'vistas/footer.php';

                    } else {

                        $mensaje_error = "Contraseña incorrecta.";
                        include 'vistas/header.php';
                        include 'vistas/panelModificarProducto.php';
                        include 'vistas/footer.php';
                    }
                }
            }
        }
        
        
        public function solicitudGestionarPedidos(){

            $AllPedidos = PedidoDAO::getAllPedidos();
        
            include 'vistas/header.php';
            include 'vistas/panelGestionarPedidos.php';
            include 'vistas/footer.php';
        }
    }
?>