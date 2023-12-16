<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Cliente.php';

    class ClienteDAO {

        // Crearemos una función para obtener la contraseña del cliente mediante su ID:
        public static function getPasswordCliente($usuario_id) {
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crear una consulta preparada para evitar inyecciones SQL
            $consulta = $conexion->prepare("SELECT credencial.password FROM credencial WHERE credencial.id_cliente = ?");
            $consulta->bind_param("i", $usuario_id);
        
            // Ejecutar la consulta
            $consulta->execute();
        
            // Obtener el resultado de la consulta
            $resultado = $consulta->get_result();
        
            if ($resultado->num_rows > 0) {
                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $resultado->fetch_object();
                $password = $fila->password;
                return $password;
            } else {
                // Si no encontramos ningún registro, devolveremos nulo:
                return null;
            }
        }
        

        public function getUsuarioPorEmail($email) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            $busqueda_credencial_cliente = "SELECT cliente.id_cliente AS ID, cliente.email, credencial.tipo_usuario, credencial.password
                                            FROM CLIENTE cliente
                                            JOIN CREDENCIAL credencial ON cliente.id_cliente = credencial.id_cliente
                                            WHERE credencial.tipo_usuario = 'cliente' AND cliente.email = ?";
            
            $busqueda_credencial_administrador = "SELECT administrador.id_administrador AS ID, administrador.email, credencial.tipo_usuario, credencial.password
                                            FROM ADMINISTRADOR ADMINISTRADOR
                                            JOIN CREDENCIAL credencial ON administrador.id_administrador = credencial.id_administrador
                                            WHERE credencial.tipo_usuario = 'administrador' AND administrador.email = ?";
        
            $credencial = null;
        
            if ($stmt = $conexion->prepare($busqueda_credencial_cliente)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $credencial = $result->fetch_object('Cliente');
                }
        
                $stmt->close();
            }
        
            if ($stmt = $conexion->prepare($busqueda_credencial_administrador)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $credencial = $result->fetch_object('Administrador');
                }
        
                $stmt->close();
            }
        
            $conexion->close();
        
            return $credencial;
        }
        
        public static function actualizarDatosCliente($idCliente, $nuevoNombre, $nuevosApellidos, $nuevaDireccion, $nuevoEmail, $nuevoTelefono) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Definir la consulta SQL para actualizar los datos del cliente
            $consultaActualizar = "UPDATE cliente SET nombre = ?, apellidos = ?, direccion = ?, email = ?, telefono = ? WHERE id_cliente = ?";
        
            // Preparar la consulta
            $stmt = $conexion->prepare($consultaActualizar);
        
            // Vincular los parámetros a la consulta
            $stmt->bind_param("sssssi", $idCliente, $nuevoNombre, $nuevosApellidos, $nuevaDireccion, $nuevoEmail, $nuevoTelefono);
        
            // Ejecutar la consulta y obtener el resultado
            $resultado = $stmt->execute();
        
            // Cerrar la consulta y la conexión
            $stmt->close();
            $conexion->close();
        
            // Devolver el resultado de la operación de actualización
            return $resultado;
        }
        

        public function eliminarCuenta($idCliente) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Eliminar pedidos asociados al cliente
            $consultaEliminarPedidos = $conexion->prepare("DELETE FROM PEDIDO WHERE id_cliente = ?");
            $consultaEliminarPedidos->bind_param("i", $idCliente);
            $consultaEliminarPedidos->execute();
            $consultaEliminarPedidos->close();
        
            // Eliminar credenciales asociadas al cliente
            $consultaEliminarCredenciales = $conexion->prepare("DELETE FROM CREDENCIAL WHERE id_cliente = ?");
            $consultaEliminarCredenciales->bind_param("i", $idCliente);
            $consultaEliminarCredenciales->execute();
            $consultaEliminarCredenciales->close();
        
            // Eliminar información del cliente
            $consultaEliminarCliente = $conexion->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
            $consultaEliminarCliente->bind_param("i", $idCliente);
            $consultaEliminarCliente->execute();
            $consultaEliminarCliente->close();
        
            // Cerrar la conexión a la base de datos
            $conexion->close();
        }
        
        
        // Crearemos una función que nos devuelva la información de un usuario por su ID:
        public static function getUsuarioByID($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
            
            // Consultar la información del usuario por su ID
            $consultaUsuario = $conexion->prepare("SELECT * FROM CLIENTE WHERE id_cliente = ?");
            $consultaUsuario->bind_param("i", $usuario_id);
            $consultaUsuario->execute();
            
            // Obtener el resultado de la consulta
            $result = $consultaUsuario->get_result();
            
            // Obtener los datos del usuario como un objeto de la clase Cliente
            $datosUsuario = $result->fetch_object('Cliente');
            
            // Cerrar la consulta y la conexión a la base de datos
            $consultaUsuario->close();
            $conexion->close();
            
            // Devolver los datos del usuario
            return $datosUsuario;
        }
            
        public function registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Verificar si el correo electrónico ya está registrado
            $consultaEmail = "SELECT * FROM CLIENTE WHERE email = ?";
            $stmtEmail = $conexion->prepare($consultaEmail);
            $stmtEmail->bind_param("s", $email);
            $stmtEmail->execute();
            $resultadoEmail = $stmtEmail->get_result();
        
            if ($resultadoEmail->num_rows == 0) {
                // Insertar al nuevo cliente en la tabla CLIENTE
                $consultaInsertarCliente = "INSERT INTO CLIENTE (nombre, apellidos, direccion, email, telefono) VALUES (?, ?, ?, ?, ?)";
                $stmtInsertarCliente = $conexion->prepare($consultaInsertarCliente);
                $stmtInsertarCliente->bind_param("sssss", $nombre, $apellidos, $direccion, $email, $telefono);
                $stmtInsertarCliente->execute();
        
                // Obtener el ID del nuevo cliente
                $idCliente = $conexion->insert_id;
        
                // Insertar las credenciales en la tabla CREDENCIAL
                $consultaInsertarCredencial = "INSERT INTO CREDENCIAL (id_cliente, tipo_usuario, password) VALUES (?, 'cliente', ?)";
                $stmtInsertarCredencial = $conexion->prepare($consultaInsertarCredencial);
                $stmtInsertarCredencial->bind_param("is", $idCliente, $password);
                $stmtInsertarCredencial->execute();
        
                // Devolver el ID del nuevo cliente
                return $idCliente;
        
            } else {
                // El correo electrónico ya está registrado
                return "El correo electrónico ya está registrado";
            }
        }
        
        public function comprobarSuscripcionNewsletter($nombre, $email) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Validación del nombre
            if (!preg_match("/[a-zA-Z]/", $nombre)) {
                return "El nombre debe contener al menos una letra";
            }
        
            // Verificar si el email ya está suscrito
            $consultaEmail = "SELECT * FROM NEWSLETTER WHERE email = ?";
            $stmtEmail = $conexion->prepare($consultaEmail);
            $stmtEmail->bind_param("s", $email);
            $stmtEmail->execute();
            $resultadoComprobacionEmail = $stmtEmail->get_result();
        
            // Verificar si el nombre ya está suscrito
            $consultaNombre = "SELECT * FROM NEWSLETTER WHERE nombre = ?";
            $stmtNombre = $conexion->prepare($consultaNombre);
            $stmtNombre->bind_param("s", $nombre);
            $stmtNombre->execute();
            $resultadoComprobacionNombre = $stmtNombre->get_result();
        
            // Si el email ya está suscrito
            if ($resultadoComprobacionEmail->num_rows > 0) {
                return "El email ya se encuentra en uso. Por favor, utiliza otro.";
            } elseif ($resultadoComprobacionNombre->num_rows > 0) {
                // Si el nombre ya está suscrito
                return "El nombre ya se encuentra en uso. Por favor, utiliza otro.";
            } else {
                // Insertar datos en la tabla Newsletter
                $altaNewsletter = "INSERT INTO NEWSLETTER (nombre, email) VALUES (?, ?)";
                $stmtAltaNewsletter = $conexion->prepare($altaNewsletter);
                $stmtAltaNewsletter->bind_param("ss", $nombre, $email);
        
                if ($stmtAltaNewsletter->execute()) {
                    return "success";
                } else {
                    return "Error al suscribirse: " . $stmtAltaNewsletter->error;
                }
            }
        }
    }
?>