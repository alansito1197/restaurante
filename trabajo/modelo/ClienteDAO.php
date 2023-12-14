<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Cliente.php';

    class ClienteDAO {

        // Crearemos una función para conectarnos a nuestra base de datos:
        public static function conectarBaseDeDatos() {
            $db = new DataBase();
            return $db->connect();
        }

        // Crearemos una función para obtener la contraseña del cliente mediante su ID:
        public static function obtenerPasswordCliente($usuario_id) {
            
            // Crearemos una consulta a la base de datos para buscar la contraseña del usuario:
            $password_bbdd = "SELECT credencial.password FROM credencial WHERE credencial.id_cliente = '$usuario_id'";

            // Ejecutaremos la consulta mediante la llamada al método que se conecta a la base de datos:
            $ejecutar_busqueda = self::conectarBaseDeDatos()->query($password_bbdd);

            if ($ejecutar_busqueda->num_rows > 0) {

                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $ejecutar_busqueda->fetch_assoc();
                return $fila['password'];

            } else {

                // Si no encontramos ningún registro, devolveremos nulo:
                return null;
            }
        }

        public static function actualizarDatosCliente($usuario_id, $nombre, $apellidos, $direccion, $email, $telefono) {
            $actualizar_datos = "UPDATE cliente SET nombre = '$nombre', apellidos = '$apellidos', direccion = '$direccion', email = '$email', telefono = $telefono WHERE id_cliente = '$usuario_id'";
            return self::conectarBaseDeDatos()->query($actualizar_datos);
        }

        public function eliminarCuenta($idCliente) {
            // Verificar si hay pedidos asociados al cliente
            $conexion = self::conectarBaseDeDatos();
    
            // Verificar si hay pedidos asociados al cliente
            $busqueda_pedidos = "SELECT id_pedido FROM PEDIDO WHERE id_cliente = '$idCliente'";
            $resultado_pedidos = $conexion->query($busqueda_pedidos);
    
            if ($resultado_pedidos->num_rows > 0) {
                // Hay pedidos asociados al cliente, eliminar pedidos primero
                while ($fila_pedido = $resultado_pedidos->fetch_assoc()) {
                    $idPedido = $fila_pedido['id_pedido'];
                    $this->eliminarPedido($idPedido);
                }
            }
    
            // Después de eliminar pedidos, eliminar credenciales y cliente
            $busqueda_credenciales = "DELETE FROM CREDENCIAL WHERE id_cliente = '$idCliente'";
            $resultado_credenciales = $conexion->query($busqueda_credenciales);
    
            if ($resultado_credenciales) {
                $busqueda_usuario = "DELETE FROM CLIENTE WHERE id_cliente = '$idCliente'";
                $resultado_usuario = $conexion->query($busqueda_usuario);
    
                return $resultado_usuario;
            } else {
                return false;
            }
        }

        public function eliminarPedido($idPedido) {
            // Eliminar detalles del pedido primero
            $queryEliminarDetalles = "DELETE FROM DETALLE_PEDIDO WHERE id_pedido = '$idPedido'";
            self::conectarBaseDeDatos()->query($queryEliminarDetalles);
        
            // Luego, eliminar el pedido
            $queryEliminarPedido = "DELETE FROM PEDIDO WHERE id_pedido = '$idPedido'";
            self::conectarBaseDeDatos()->query($queryEliminarPedido);
        }

        public function registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password) {

            $conexion = self::conectarBaseDeDatos();
        
            // Verificamos si el correo electrónico ya está registrado
            $consulta_email = "SELECT * FROM CLIENTE WHERE email = ?";
            $stmt = $conexion->prepare($consulta_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado_email = $stmt->get_result();
        
            if ($resultado_email->num_rows == 0) {
                // Insertamos al nuevo cliente en la tabla CLIENTE
                $consulta_insertar_cliente = "INSERT INTO CLIENTE (nombre, apellidos, direccion, email, telefono) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($consulta_insertar_cliente);
                $stmt->bind_param("sssss", $nombre, $apellidos, $direccion, $email, $telefono);
                $stmt->execute();
        
                // Obtenemos el ID del nuevo cliente
                $id_cliente = $conexion->insert_id;
        
                // Insertamos las credenciales en la tabla CREDENCIAL
                $consulta_insertar_credencial = "INSERT INTO CREDENCIAL (id_cliente, tipo_usuario, password) VALUES (?, 'cliente', ?)";
                $stmt = $conexion->prepare($consulta_insertar_credencial);
                $stmt->bind_param("is", $id_cliente, $password);
                $stmt->execute();
        
                // Devolvemos el ID del nuevo cliente
                return $id_cliente;
        
            } else {
                // El correo electrónico ya está registrado
                return "El correo electrónico ya está registrado";
            }
        }

        public function comprobarSuscripcionNewsletter($nombre, $email) {

            $conexion = self::conectarBaseDeDatos();

            // Validación del nombre
            if (!preg_match("/[a-zA-Z]/", $nombre)) {
                return "El nombre debe contener al menos una letra";
            }

            // Verificar si el email ya está suscrito
            $busqueda_email = "SELECT * FROM NEWSLETTER WHERE email = ?";
            $stmt = $conexion->prepare($busqueda_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado_comprobacion_email = $stmt->get_result();

            // Verificar si el nombre ya está suscrito
            $busqueda_nombre = "SELECT * FROM NEWSLETTER WHERE nombre = ?";
            $stmt = $conexion->prepare($busqueda_nombre);
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $resultado_comprobacion_nombre = $stmt->get_result();

            // Si el email ya está suscrito
            if ($resultado_comprobacion_email->num_rows > 0) {
                return "El email ya se encuentra en uso. Por favor, utiliza otro.";
            } elseif ($resultado_comprobacion_nombre->num_rows > 0) {
                // Si el nombre ya está suscrito
                return "El nombre ya se encuentra en uso. Por favor, utiliza otro.";
            } else {
                // Insertar datos en la tabla Newsletter
                $alta_newsletter = "INSERT INTO NEWSLETTER (nombre, email) VALUES (?, ?)";
                $stmt = $conexion->prepare($alta_newsletter);
                $stmt->bind_param("ss", $nombre, $email);

                if ($stmt->execute()) {
                    return "success";
                } else {
                    return "Error al suscribirse: " . $stmt->error;
                }
            }
        }
    }
?>