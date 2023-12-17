<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Pedido.php';
    include_once 'modelo/AllPedidos.php';
    include_once 'modelo/PedidoUsuario.php';

    class PedidoDAO {

        public static function insertarPedido($usuario_id, $precioTotalPedido, $fechaPedido, $estadoPedido, $tipoUsuario) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $queryInsertPedido = "INSERT INTO PEDIDO (id_cliente, precio_total, fecha, estado, tipo_usuario) VALUES ($usuario_id, $precioTotalPedido, '$fechaPedido', '$estadoPedido', '$tipoUsuario')";
            $resultadoInsertPedido = $conexion->query($queryInsertPedido);
        
            if ($resultadoInsertPedido) {
                return $conexion->insert_id;
            } else {
                return false;
            }
        }

        public static function insertarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnidad) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $queryInsertDetallePedido = "INSERT INTO DETALLE_PEDIDO (id_pedido, id_producto, cantidad, precio_unidad) VALUES ($idPedido, $idProducto, $cantidad, $precioUnidad)";
            return $conexion->query($queryInsertDetallePedido);
        }

        // Crearemos un método para obtener todos los pedidos de cada usuario:
        public static function obtenerPedidosUsuario($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            $busqueda_pedidos = "SELECT * FROM PEDIDO WHERE id_cliente = ? AND tipo_usuario = ?";
            
            $stmt = $conexion->prepare($busqueda_pedidos);
            $stmt->bind_param("is", $usuario_id, $_SESSION['tipo_usuario']);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            $pedidos = array();
        
            while ($obj = $result->fetch_object('PedidoUsuario')) {
                $pedidos[] = $obj;
            }
        
            $stmt->close();
            $conexion->close();
        
            return $pedidos;
        }
        

        public static function getAllPedidos() {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $sql = "SELECT * FROM PEDIDO";
            $resultado = $conexion->query($sql);

            $pedidos = array();

            while ($fila = $resultado->fetch_object('AllPedidos')) {
                $pedidos[] = $fila;
            }

            // Almacena los productos en una variable de sesión
            $_SESSION['pedidos'] = $pedidos;

            $conexion->close();

            return $pedidos;
        }

        public static function precioUltimoPedido($usuario_id) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $query = "SELECT precio_total FROM PEDIDO WHERE id_cliente = ? AND tipo_usuario = ? ORDER BY id_pedido DESC LIMIT 1";
            
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("is", $usuario_id, $_SESSION['tipo_usuario']);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_object();
                $precio_total = $row->precio_total;
                return $precio_total;
            } else {
                echo "No se encontraron pedidos.";
                return null;
            }  
        }

        public function eliminarPedido($idPedido) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Eliminar detalles del pedido y luego el pedido
            $consultaDetalles = $conexion->prepare("DELETE FROM DETALLE_PEDIDO WHERE id_pedido = ?");
            $consultaDetalles->bind_param("i", $idPedido);
            $consultaDetalles->execute();
            $consultaDetalles->close();
        
            $consultaPedido = $conexion->prepare("DELETE FROM PEDIDO WHERE id_pedido = ?");
            $consultaPedido->bind_param("i", $idPedido);
            $consultaPedido->execute();
            $consultaPedido->close();
        
            $conexion->close();
        }
    }
?>