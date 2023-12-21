<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Pedido.php';
    include_once 'modelo/Pedidos.php';

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
        public static function obtenerPedidoUsuario($usuario_id) {

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
        
            // Mediante un bucle, iremos guardando cada pedido en la variable anterior:
            while ($objeto = $resultado->fetch_object('Pedidos')) {
                $pedidos[] = $objeto;
            }
        
            // Cerraremos la conexión a la base de datos y la consulta:
            $stmt->close();
            $conexion->close();
        
            // Devolveremos el resultado de la consulta:
            return $pedidos;
        }
        
        // Crearemos una función que nos devuelva todos los pedidos de la web:
        public static function getAllPedidos() {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Crearemos la consulta que nos devuelva toda la información de cada pedido:
            $seleccionarTodosPedidos = "SELECT * FROM PEDIDO";

            // Ejecutaremos la consulta:
            $resultado = $conexion->query($seleccionarTodosPedidos);

            // Crearemos una variable definiéndola como array para después almacenar cada objeto en ella:
            $pedidos = array();

            // Mediante un bucle, iremos guardando cada pedido en la variable anterior:
            while ($fila = $resultado->fetch_object('Pedidos')) {
                $pedidos[] = $fila;
            }

            // Cerraremos la conexión a la base de datos y la consulta:
            $conexion->close();
            $resultado->close();

            // Devolveremos el resultado de la consulta:
            return $pedidos;
        }

        // Crearemos una función para obtener el pedido en cuestión mediante su ID:
        public static function getPedidoByID($id_pedido) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Preparamos la consulta para obtener el producto por ID:
            $stmt = $conexion->prepare("SELECT * FROM PEDIDO WHERE id_pedido=?");
        
            // Vinculamos los parámetros:
            $stmt->bind_param("i", $id_pedido);
        
            // Ejecutamos la consulta:
            $stmt->execute();
        
            // Guardamos en una variable el resultado de la consulta:
            $resultado = $stmt->get_result();
        
            // Obtenemos el objeto Pedido utilizando fetch_object:
            $pedidoActual = $resultado->fetch_object('Pedidos');
        
            // Cerramos la conexión a la base de datos:
            $conexion->close();
        
            // No necesitas almacenar el objeto en la sesión, simplemente devuélvelo:
            return $pedidoActual;
        }        

        // Crearemos una función que nos ayudará a obtener el precio del último pedido realizado por usuario:
        public static function precioUltimoPedido($usuario_id) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Iremos a buscar el último registro de cada usuario:
            $busqueda_UltimoPedido = "SELECT precio_total FROM PEDIDO WHERE id_cliente = ? AND tipo_usuario = ? ORDER BY id_pedido DESC LIMIT 1";
            
            // Preparamos la consulta:
            $stmt = $conexion->prepare($busqueda_UltimoPedido);
            
            // Vinculamos los parámetros:
            $stmt->bind_param("is", $usuario_id, $_SESSION['tipo_usuario']);

            // Ejecutamos la consulta:
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

        // Crearemos una función para modificar un pedido existente en nuestra base de datos:
        public static function actualizarPedido($id_pedido, $id_cliente, $tipoUsuario, $precioTotal, $fecha, $estado) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
    
            // Creamos una consulta para actualizar los datos del producto:
            $pedido = "UPDATE PEDIDO SET id_cliente = ?, tipo_usuario = ?, precio_total = ?, fecha = ?, estado = ? WHERE id_pedido = ?";
    
            // Preparamos la consulta:
            $stmt = $conexion->prepare($pedido);
    
            // Vinculamos los parámetros:
            $stmt->bind_param("ssdssi", $id_cliente, $tipoUsuario, $precioTotal, $fecha, $estado, $id_pedido);
                
            // Ejecutamos la consulta
            $stmt->execute();
    
            // Guardamos el resultado en una variable:
            $resultado = $stmt->get_result();
            
            // Cerramos la conexión a la base de datos y la consulta:
            $stmt->close();
            $conexion->close();
                
            // Devolvemos el resultado de la actualización producto:
            return $resultado;
        }

        // Crearemos una función para eliminar un pedido en concreto:
        public static function eliminarPedido($idPedido) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Eliminaremos los detalles del pedido:
            $consultaDetalles = $conexion->prepare("DELETE FROM DETALLE_PEDIDO WHERE id_pedido = ?");
            
            // Preparamos la consulta:
            $consultaDetalles->bind_param("i", $idPedido);

            // Ejecutamos la consulta:
            $consultaDetalles->execute();

            // Cerramos la consulta:
            $consultaDetalles->close();
        
            // Eliminaremos la entrada del pedido:
            $consultaPedido = $conexion->prepare("DELETE FROM PEDIDO WHERE id_pedido = ?");

            // Preparamos la consulta:
            $consultaPedido->bind_param("i", $idPedido);

            // Ejecutamos la consulta:
            $consultaPedido->execute();

            // Cerramos la consulta:
            $consultaPedido->close();
        
            // Cerraremos la conexión a la base de datos:
            $conexion->close();
        }
    }
?>