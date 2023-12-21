<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/PedidoDAO.php';

    class pedidoController {

        // Crearemos una función que se encargue de gestionar la tramitación del pedido:
        public function tramitarPedido() {

            if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre']) || !isset($_SESSION['tipo_usuario'])|| !isset($_SESSION['password'])) {
        
                // Primero, comprobaremos si el usuario que intenta tramitar un pedido ha iniciado sesión previamente, si no, le informaremos que debe hacerlo:
                include 'vistas/header.php';
                include 'vistas/panelInicioSesionRequerido.php';
                include 'vistas/footer.php';
            
            } else {

                // Si el usuario tiene sesión iniciada, guardaremos la información que necesitamos para tramitar el pedido en variables:
                $usuario_id = $_SESSION['usuario_id'];
                $productosSeleccionados = $_SESSION['productosSeleccionados'];
                $precioTotalPedido = $_SESSION['precioTotalCarrito'];
                $fechaPedido = date("Y-m-d H:i:s");
                $estadoPedido = "OK";

                // Llamaremos al método que crea el pedido enviándole por parámetro las variables anteriores:
                $idPedido = PedidoDAO::insertarPedido($usuario_id, $precioTotalPedido, $fechaPedido, $estadoPedido, $_SESSION['tipo_usuario']);

                if ($idPedido) {

                    // Si el método anterior devuelve true, haremos lo siguiente:

                    foreach ($productosSeleccionados as $pedidoSerializaded){

                        // Por cada pedido, lo deserializaremos:
                        $pedido = unserialize ($pedidoSerializaded);

                        // Guardaremos el ID de cada producto:
                        $idProducto = $pedido->getProducto()->getIdProducto();

                        // Guardaremos la cantidad total de productos del pedido:
                        $cantidad = $pedido->getCantidad();

                        // Obtendremos el precio de cada producto:
                        $precioUnidad = $pedido->getProducto()->getPrecio();

                        // Utilizaremos las variables anteriores para insertarlas en el detalle del pedido
                        PedidoDAO::insertarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnidad);
                    }

                    // Borraremos las variables de sesión que hemos utilizado para crear el pedido:
                    unset($_SESSION['productosSeleccionados']);
                    unset($_SESSION['opcionLugarConsumir']);
                    unset($_SESSION['precioTotalCarrito']);
                }

                // Almacenaremos el precio del último pedido en una cookie temporal:
                
                // Primero, recuperaremos el precio del último pedido gracias a la llamada del método que lo obtiene:
                $precioUltimoPedido = PedidoDAO::precioUltimoPedido($usuario_id);

                // También recuperaremos el tipo de usuario que tramita el pedido, para que no confunda el cliente con ID 1 con el administrador con ID 1:
                $tipo_usuario = $_SESSION['tipo_usuario'];

                // Crearemos la cookie almacenando el valor que devuelve el método anterior junto con el ID de usuario para diferenciarlo entre los distintos usuarios de la web:
                setcookie('CookieUltimoPedido_' . $usuario_id . '_' . $tipo_usuario, $precioUltimoPedido, time() + 3600);

                // Incluiremos las vistas necesarias:
                include 'vistas/header.php';
                include 'vistas/panelTramitarPedido.php';
                include 'vistas/footer.php';

                exit();
            }
        }

        // Crearemos un método para mostrar a cada usuario de la web los pedidos que ha realizado:
        public function mostrarPedidosUsuario(){

            // Recuperaremos el ID del usuario gracias a la variable de sesión que tenemos almacenada:
            $usuario_id = $_SESSION['usuario_id'];

            // Llamaremos al método que obtiene los pedidos por usuario enviándole por parámetro el ID del usuario que lo solicita:
            $pedidos = PedidoDAO::obtenerPedidoUsuario($usuario_id);

            if ($pedidos) {

                // Si la llamada al método que obtiene los pedidos devuelve true, le mostraremos la vista con sus pedidos:
                include 'vistas/header.php';
                include 'vistas/panelPedidosCliente.php';
                include 'vistas/footer.php';
            
            } else {

                // Si la llamada al método que obtiene los pedidos devuelve false, le mostraremos la vista que le indicará que no tiene pedidos:
                include 'vistas/header.php';
                include 'vistas/panelPedidosVacio.php';
                include 'vistas/footer.php';
            }
        }
    }
?>