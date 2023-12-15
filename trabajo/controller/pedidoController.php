<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/PedidoDAO.php';
    
    class pedidoController {

        // Crearemos una función que se encargue de gestionar los pedidos:
        public function tramitarPedido() {

            if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre']) || !isset($_SESSION['tipo_usuario']) || !isset($_SESSION['password'])) {

                include 'vistas/header.php';
                include 'vistas/panelInicioSesionRequerido.php';
                include 'vistas/footer.php';
                
            } else {

                $usuario_id = $_SESSION['usuario_id'];
                $productosSeleccionados = $_SESSION['productosSeleccionados'];
                $precioTotalPedido = $_SESSION['precioTotalCarrito'];
                $fechaPedido = date("Y-m-d H:i:s");
                $estadoPedido = "OK";
        
                $idPedido = PedidoDAO::insertarPedido($usuario_id, $precioTotalPedido, $fechaPedido, $estadoPedido, $_SESSION['tipo_usuario']);
        
                if ($idPedido) {

                    foreach ($productosSeleccionados as $pedidoSerialized) {
                        $pedido = unserialize($pedidoSerialized);
                        $idProducto = $pedido->getProducto()->getIdProducto();
                        $cantidad = $pedido->getCantidad();
                        $precioUnidad = $pedido->getProducto()->getPrecio();
        
                        PedidoDAO::insertarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnidad);
                    }
        
                    unset($_SESSION['productosSeleccionados']);
                    unset($_SESSION['opcionLugarConsumir']);
                    unset($_SESSION['precioTotalCarrito']);
                }


                    // Almacena el precio del último pedido en una cookie temporal
                    $usuario_id = $_SESSION['usuario_id'];
                    $precioUltimoPedido = PedidoDAO::precioUltimoPedido($usuario_id);
        
                    // Verifica si se obtuvo un precio y almacena la cookie
                    if ($precioUltimoPedido !== null) {
                        setcookie('UltimoPedido', $precioUltimoPedido, time() + 3600);  // La cookie expirará en 1 hora
                    }

        
                include 'vistas/header.php';
                include 'vistas/panelTramitarPedido.php';
                include 'vistas/footer.php';
        
                exit();
            }
        }

        public function mostrarPedidosUsuario(){

            $usuario_id = $_SESSION['usuario_id'];

            //Obtendremos los pedidos del usuario llamándo al método que se encarga de buscarlos:
            $pedidos = PedidoDAO::obtenerPedidosUsuario($usuario_id);

            if ($pedidos) {

                // Si hay pedidos, cargaremos la vista que contiene los pedidos
                include 'vistas/header.php';
                include 'vistas/panelPedidosCliente.php';
                include 'vistas/footer.php';
            } else {
                // Si no hay pedidos, cargaremos la vista sin pedidos
                include 'vistas/header.php';
                include 'vistas/panelPedidosVacio.php';
                include 'vistas/footer.php';
            }
        }
    }
?>