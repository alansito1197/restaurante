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

                $id_administrador = $_SESSION ['usuario_id'];

                $nombre = $_POST['nombre'];
                $categoria_producto = $_POST['categoria_producto'];
                $sabor = $_POST['sabor'];
                $calorias = $_POST['calorias'];
                $precio = $_POST['precio'];
                $disponibilidad = $_POST['disponibilidad'];
                $stock = $_POST['stock'];
                $ingredientes = $_POST['ingredientes'];
                $destacado = $_POST['destacado'];
                $imagen = $_FILES['imagen']['name'];
                $imagen_tmp = $_FILES['imagen']['tmp_name'];

                $valoracion = $_FILES['valoracion']['name'];
                $valoracion_tmp = $_FILES['valoracion']['tmp_name'];

                $ruta_imagen = "assets/imagenes/productos/nuevo/" . $imagen;
                $ruta_valoracion = "assets/imagenes/iconos/valoraciones/" . $valoracion;

                move_uploaded_file($imagen_tmp, $ruta_imagen);
                move_uploaded_file($valoracion_tmp, $ruta_valoracion);
    
                try {

                    $productoDAO = new AdministradorDAO();
                    $resultado = $productoDAO->agregarProducto($id_administrador, $categoria_producto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado,  $ruta_imagen, $ruta_valoracion,);

                    if ($resultado) {
                        
                        echo '<script>';
                        echo 'alert("¡Producto agregado con éxito!");';
                        echo 'window.location.href="'.url.'?controller=admin&action=solicitudCrearProducto";';
                        echo '</script>';

                    } else {

                        echo '<script>';
                        echo 'alert("¡No se ha podido agregar al producto!");';
                        echo 'window.location.href="'.url.'?controller=admin&action=solicitudCrearProducto";';
                        echo '</script>';
                    }

                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
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

            $productoDAO = new AdministradorDAO();
            $productoActual = $productoDAO->obtenerProductoPorId($idProducto);
            $_SESSION['productoActual'] = $productoActual;
        
            include 'vistas/header.php';
            include 'vistas/panelModificarProducto.php';
            include 'vistas/footer.php';
        }

        public function actualizarProductoSeleccionado() {

            // Guardaremos el ID del usuario actual en una variable:
            $usuario_id = $_SESSION['usuario_id'];

            // Guardaremos el ID del usuario actual en una variable:
            $idProducto = $_SESSION['productoActual'];
            
            // Verifica si se envió el formulario:

            if (isset($_POST['modificar_producto'])) {

                $idProducto = $_SESSION['productoActual'];
                $nombre = $_POST['nombre'];
                $sabor = $_POST['sabor'];
                $valor_energetico = $_POST['valor_energetico'];
                $precio = $_POST['precio'];
                $disponibilidad = $_POST['disponibilidad'];
                $stock = $_POST['stock'];
                $imagen = $_POST['imagen'];
                $ingredientes = $_POST['ingredientes'];
                $producto_destacado = $_POST['producto_destacado'];
                $password = $_POST['password'];

                // Obtendremos la contraseña del cliente en la base de datos mediante la llamada del método que se encarga de recuperarla:
                $contrasena_almacenada = AdministradorDAO::obtenerPasswordAdmin($usuario_id);
                
                if ($contrasena_almacenada !== null && $password == $contrasena_almacenada) {

                    AdministradorDAO::actualizarProducto($idProducto, $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $imagen, $ingredientes, $producto_destacado);
                            
                    header('Location:'.url.'?controller=admin&action=solicitudGestionarProductos');
                        
                } else {

                    /* Si la contraseña indicada no coincide con la guardada en la base de datos, le mostraremos un mensaje de error por pantalla y redirigiremos al cliente a
                    la misma página para que pueda volver a intentarlo: */ 
                        
                    echo '<script>alert("Contraseña incorrecta. Inténtalo de nuevo."); window.location.href="'.url.'?controller=admin&action=modificarProducto";</script>';
                    exit();
                }
            }
        }

        public function eliminarProducto($idProducto) {

            $productoDAO = new AdministradorDAO();
            $productoActual = $productoDAO->obtenerProductoPorId($idProducto);
            $_SESSION['productoActual'] = $productoActual;
            
            include 'vistas/header.php';
            include 'vistas/panelEliminarProducto.php';
            include 'vistas/footer.php';
        }

        public function solicitudGestionarPedidos(){

            $pedidoDAO = new PedidoDAO();
            $_SESSION['pedidos'] = $pedidoDAO->obtenerTodosLosPedidos();
        
            include 'vistas/header.php';
            include 'vistas/panelEscogerPedido.php';
            include 'vistas/footer.php';
        }

        public function solicitudGestionarProductos() {

            $productoDAO = new AdministradorDAO();
        
            
            $_SESSION['productos'] = $productoDAO->obtenerTodosLosProductos();
        
            include 'vistas/header.php';
            include 'vistas/panelEscogerProducto.php';
            include 'vistas/footer.php';
        }
        
    }
?>