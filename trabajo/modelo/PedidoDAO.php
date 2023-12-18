<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Pedido.php';
    include_once 'modelo/AllPedidos.php';
    include_once 'modelo/PedidoUsuario.php';

    class PedidoDAO {

        // Crearemos una función para insertar el pedido del usuario en la base de datos:
        public static function insertarPedido($usuario_id, $precioTotalPedido, $fechaPedido, $estadoPedido, $tipoUsuario) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Creamos una consulta para insertar el pedido en la base de datos enviándole por parámetro las variables que nos interesa:
            $insertarPedido = "INSERT INTO PEDIDO (id_cliente, precio_total, fecha, estado, tipo_usuario) VALUES ($usuario_id, $precioTotalPedido, '$fechaPedido', '$estadoPedido', '$tipoUsuario')";
            
            // Almacenaremos el resultado del pedido en una variable:
            $resultadoInsertarPedido = $conexion->query($insertarPedido);
        
            if ($resultadoInsertarPedido) {

                // Si la consulta se ejecutó correctamente, devolveremos el ID del pedido:
                return $conexion->insert_id;
            }
        }

        // Crearemos una función para insertar el detalle del pedido en la base de datos:
        public static function insertarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnidad) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Crearemos una consulta para insertar el detalle del pedido en la base de datos:
            $insertarDetallePedido = "INSERT INTO DETALLE_PEDIDO (id_pedido, id_producto, cantidad, precio_unidad) VALUES ($idPedido, $idProducto, $cantidad, $precioUnidad)";
            
            // Devolveremos el resultado de la consulta anterior:
            return $conexion->query($insertarDetallePedido);
        }
        
        // Crearemos un método para obtener todos los pedidos de cada usuario:
        public static function obtenerPedidosUsuario($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una query para obtener todos los datos del pedido:
            $busqueda_pedidos = "SELECT * FROM PEDIDO WHERE id_cliente = ? AND tipo_usuario = ?";
            
            // Preparamos la consulta:
            $stmt = $conexion->prepare($busqueda_pedidos);

            // Vinculamos los parámetros:
            $stmt->bind_param("is", $usuario_id, $_SESSION['tipo_usuario']);

            // Ejecutaremos la consulta:
            $stmt->execute();
        
            // Guardaremos en una variable el resultado de la consulta:
            $resultado = $stmt->get_result();
        
            // Definiremos como array la variable donde almacenaremos cada pedido del usuario:
            $pedidos = array();
        
            while ($objeto = $resultado->fetch_object('PedidoUsuario')) {
                $pedidos[] = $objeto;
            }
        
            // Cerraremos la conexión a la base de datos y la consulta:
            $stmt->close();
            $conexion->close();
        
            // Devolveremos el resultado de la consulta:
            return $pedidos;
        }
        
        public static function getAllPedidos() {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $seleccionarTodosPedidos = "SELECT * FROM PEDIDO";
            $resultado = $conexion->query($seleccionarTodosPedidos);

            $pedidos = array();

            while ($fila = $resultado->fetch_object('AllPedidos')) {
                $pedidos[] = $fila;
            }

            // Almacenaremos los productos en una variable de sesión:
            $_SESSION['pedidos'] = $pedidos;

            // Cerraremos la conexión a la base de datos y la consulta:
            $conexion->close();
            $resultado->close();

            // Devolveremos el resultado de la consulta:
            return $pedidos;
        }

        public static function precioUltimoPedido($usuario_id) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            $busqueda_UltimoPedido = "SELECT precio_total FROM PEDIDO WHERE id_cliente = ? AND tipo_usuario = ? ORDER BY id_pedido DESC LIMIT 1";
            
            $stmt = $conexion->prepare($busqueda_UltimoPedido);
            $stmt->bind_param("is", $usuario_id, $_SESSION['tipo_usuario']);
            $stmt->execute();
        
            // Guardaremos en una variable el resultado de la consulta:
            $resultado = $stmt->get_result();
        
            if ($resultado->num_rows > 0) {

                $row = $resultado->fetch_object();
                $precio_total = $row->precio_total;
                // Devolveremos el resultado de la consulta:
                return $precio_total;
            }  
        }

        public function eliminarPedido($idPedido) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Eliminaremos los detalles del pedido:
            $consultaDetalles = $conexion->prepare("DELETE FROM DETALLE_PEDIDO WHERE id_pedido = ?");
            $consultaDetalles->bind_param("i", $idPedido);
            $consultaDetalles->execute();
            $consultaDetalles->close();
        
            // Eliminaremos la entrada del pedido:
            $consultaPedido = $conexion->prepare("DELETE FROM PEDIDO WHERE id_pedido = ?");
            $consultaPedido->bind_param("i", $idPedido);
            $consultaPedido->execute();
            $consultaPedido->close();
        
            // Cerraremos la conexión a la base de datos:
            $conexion->close();
        }
    }
?>