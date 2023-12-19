<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Cliente.php';

    class ClienteDAO {

        // Crearemos una función para obtener la contraseña del cliente mediante su ID:
        public static function getPasswordCliente($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una consulta para obtener la contraseña del administrador:
            $consulta = $conexion->prepare("SELECT credencial.password FROM CREDENCIAL WHERE credencial.id_cliente = ?");

            // Vincularemos los parámetros:
            $consulta->bind_param("i", $usuario_id);
        
            // Ejecutaremos la consulta:
            $consulta->execute();
        
            // Obtendremos el resultado de la consulta y lo guardaremos en una variable:
            $resultado = $consulta->get_result();
        
            if ($resultado->num_rows > 0) {

                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $resultado->fetch_object();
                $password = $fila->password;
                return $password;
            } 
        }
        
        // Crearemos una función para comprobar si el email introducido por el nuevo usuario ya se encuentra en la base de datos:
        public function getUsuarioExistente($email) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una consulta para buscar si una cuenta de cliente coincide con la introducida:
            $busqueda_credencial_cliente = "SELECT cliente.id_cliente AS ID, cliente.email, credencial.tipo_usuario, credencial.password
                                            FROM CLIENTE cliente
                                            JOIN CREDENCIAL credencial ON cliente.id_cliente = credencial.id_cliente
                                            WHERE credencial.tipo_usuario = 'cliente' AND cliente.email = ?";
            
            // Crearemos una consulta para buscar si una cuenta de administrador coincide con la introducida:
            $busqueda_credencial_administrador = "SELECT administrador.id_administrador AS ID, administrador.email, credencial.tipo_usuario, credencial.password
                                                  FROM ADMINISTRADOR ADMINISTRADOR
                                                  JOIN CREDENCIAL credencial ON administrador.id_administrador = credencial.id_administrador
                                                  WHERE credencial.tipo_usuario = 'administrador' AND administrador.email = ?";
        
            // Inicializaremos la variable que más tarde devolveremos como true or false:
            $usuario = null;
        
            if ($stmtCliente = $conexion->prepare($busqueda_credencial_cliente)) {
                
                // Vincularemos los parámetros a la consulta:
                $stmtCliente->bind_param("s", $email);

                // Ejecutaremos la consulta:
                $stmtCliente->execute();

                // Obtendremos el resultado de la consulta:
                $resultado = $stmtCliente->get_result();
        
                if ($resultado->num_rows > 0) {
                    $usuario = $resultado->fetch_object('Cliente');
                }
        
                // Cerraremos la consulta y la conexión a la base de datos:
                $stmtCliente->close();
            }
        
            if ($stmtAdministrador = $conexion->prepare($busqueda_credencial_administrador)) {
                
                // Vincularemos los parámetros a la consulta:
                $stmtAdministrador->bind_param("s", $email);

                // Ejecutaremos la consulta:
                $stmtAdministrador->execute();

                // Obtendremos el resultado de la consulta:
                $resultado = $stmtAdministrador->get_result();
        
                if ($resultado->num_rows > 0) {
                    $usuario = $resultado->fetch_object('Administrador');
                }
        
                // Cerraremos la consulta:
                $stmtAdministrador->close();
            }
        
            // Cerraremos la conexión a la base de datos:
            $conexion->close();
        
            // Devolveremos el resultado de la consulta:
            return $usuario;
        }
        
        // Crearemos una función para modificar la cuenta del cliente:
        public static function actualizarDatosCliente($idCliente, $nuevoNombre, $nuevosApellidos, $nuevaDireccion, $nuevoEmail, $nuevoTelefono) {
    
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Creamos la consulta para actualizar los datos del cliente:
            $consultaActualizar = "UPDATE CLIENTE SET nombre = ?, apellidos = ?, direccion = ?, email = ?, telefono = ? WHERE id_cliente = ?";
        
            // Prepararemos la consulta:
            $stmt = $conexion->prepare($consultaActualizar);
        
            // Vincularemos los parámetros a la consulta:
            $stmt->bind_param("sssssi", $nuevoNombre, $nuevosApellidos, $nuevaDireccion, $nuevoEmail, $nuevoTelefono, $idCliente);
        
            // Ejecutaremos la consulta y obtendremos el resultado:
            $resultado = $stmt->execute();
        
            // Cerraremos la consulta y la conexión a la base de datos:
            $stmt->close();
            $conexion->close();
        
            // Devolver el resultado de la operación de actualización:
            return $resultado;
        }
        
        // Crearemos una función para eliminar la cuenta del cliente que desea darse de baja de nuestra web:
        public function eliminarCuenta($idCliente) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Eliminar .los pedidos asociados al cliente:
            $consultaEliminarPedidos = $conexion->prepare("DELETE FROM PEDIDO WHERE id_cliente = ?");
            
            // Vincularemos los parámetros a la consulta:
            $consultaEliminarPedidos->bind_param("i", $idCliente);
            
            // Ejecutaremos la consulta:
            $consultaEliminarPedidos->execute();
            
            // Cerraremos la consulta:
            $consultaEliminarPedidos->close();
        
            // Eliminar las credenciales asociadas al cliente:
            $consultaEliminarCredenciales = $conexion->prepare("DELETE FROM CREDENCIAL WHERE id_cliente = ?");
            
            $consultaEliminarCredenciales->bind_param("i", $idCliente);
            // Ejecutaremos la consulta:
            $consultaEliminarCredenciales->execute();
            
            // Cerraremos la consulta
            $consultaEliminarCredenciales->close();
        
            // Eliminaremos las credenciales asociadas al cliente:
            $consultaEliminarCliente = $conexion->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
            
            // Vincularemos los parámetros a la consulta:
            $consultaEliminarCliente->bind_param("i", $idCliente);
            
            // Ejecutaremos la consulta:
            $consultaEliminarCliente->execute();
            
            // Cerraremos la consulta
            $consultaEliminarCliente->close();
        
            // Cerraremos la conexión a la base de datos:
            $conexion->close();
        }
        
        // Crearemos una función que nos devuelva la información de un usuario por su ID:
        public static function getUsuarioByID($usuario_id) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
            
            // Consultaremos la información del usuario por su ID:
            $consultaUsuario = $conexion->prepare("SELECT * FROM CLIENTE WHERE id_cliente = ?");

            // Vincularemos los parámetros a la consulta:
            $consultaUsuario->bind_param("i", $usuario_id);

            // Ejecutaremos la consulta:
            $consultaUsuario->execute();
            
            // Obtendremos el resultado de la consulta:
            $result = $consultaUsuario->get_result();
            
            // Obtendremos los datos del usuario como un objeto de la clase Cliente
            $datosUsuario = $result->fetch_object('Cliente');
            
            // Cerraremos la consulta y la conexión a la base de datos:
            $consultaUsuario->close();
            $conexion->close();
            
            // Devolveremos el resultado de la consulta:
            return $datosUsuario;
        }
            
        // Crearemos una función para registrar los nuevos clientes a la web:
        public function registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Verificaremos si el correo electrónico indicado ya está registrado previamente:
            $consultaEmail = "SELECT * FROM CLIENTE WHERE email = ?";

            // Prepararemos la consulta:
            $stmtEmail = $conexion->prepare($consultaEmail);

            // Vincularemos los parámetros:
            $stmtEmail->bind_param("s", $email);

            // Ejecutaremos la consulta:
            $stmtEmail->execute();

            // Guardaremos el resultado de la consulta en una variable:
            $resultadoEmail = $stmtEmail->get_result();
        
            if ($resultadoEmail->num_rows == 0) {

                // Si no encontramos ninguna coincidencia, insertaremos al nuevo cliente en la tabla cliente:
                $consultaInsertarCliente = "INSERT INTO CLIENTE (nombre, apellidos, direccion, email, telefono) VALUES (?, ?, ?, ?, ?)";
                
                // Prepararemos la consulta:
                $stmtInsertarCliente = $conexion->prepare($consultaInsertarCliente);
                
                // Vincularemos los parámetros:
                $stmtInsertarCliente->bind_param("sssss", $nombre, $apellidos, $direccion, $email, $telefono);
                
                // Ejecutaremos la consulta:
                $stmtInsertarCliente->execute();
        
                // Obtendremos el ID del nuevo cliente:
                $idCliente = $conexion->insert_id;
        
                // Insertaremos las credenciales del cliente en la tabla credencial:
                $consultaInsertarCredencial = "INSERT INTO CREDENCIAL (id_cliente, tipo_usuario, password) VALUES (?, 'cliente', ?)";
                
                // Prepararemos la consulta:
                $stmtInsertarCredencial = $conexion->prepare($consultaInsertarCredencial);
                
                // Vincularemos los parámetros:
                $stmtInsertarCredencial->bind_param("is", $idCliente, $password);

                // Ejecutaremos la consulta:
                $stmtInsertarCredencial->execute();
        
                // Devolver el ID del nuevo cliente
                return $idCliente;
        
            } else {

                // Si el correo introducido se encuentra en nuestra base de datos, le daremos un mensaje por pantalla: 
                return "El correo electrónico ya está registrado";
            }
        }
        
        // Crearemos una función para comprobar si el intento de suscripción a la Newsletter es válido:
        public function comprobarSuscripcionNewsletter($nombre, $email) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Validaremos el nombre introducido, ya que tiene que tener mínimo una letra:
            if (!preg_match("/[a-zA-Z]/", $nombre)) {

                return "El nombre debe contener al menos una letra";
            }
        
            // Crearemos una consulta para verificar si el email ya está suscrito previamente al intento:
            $consultaEmail = "SELECT * FROM NEWSLETTER WHERE email = ?";

            // Prepararemos la consulta:
            $stmtEmail = $conexion->prepare($consultaEmail);

            // Vincularemos los parámetros:
            $stmtEmail->bind_param("s", $email);

            // Ejecutaremos la consulta:
            $stmtEmail->execute();

            // Obtendremos el resultado de la consulta:
            $resultadoComprobacionEmail = $stmtEmail->get_result();
        
            // Crearemos una consulta para comprobar si si el nombre ya está suscrito:
            $consultaNombre = "SELECT * FROM NEWSLETTER WHERE nombre = ?";

            // Prepararemos la consulta:
            $stmtNombre = $conexion->prepare($consultaNombre);

            // Vincularemos los parámetros:
            $stmtNombre->bind_param("s", $nombre);

            // Ejecutaremos la consulta:
            $stmtNombre->execute();

            // Guardaremos el resultado de la consulta en una variable:
            $resultadoComprobacionNombre = $stmtNombre->get_result();
        
            // Si encontramos un email que coincida con el indicado por el usuario le mostararemos un mensaje de error:
            if ($resultadoComprobacionEmail->num_rows > 0) {

                return "El email ya se encuentra en uso. Por favor, utiliza otro.";
            
            } elseif ($resultadoComprobacionNombre->num_rows > 0) {

                // Si encontramos un nombre de usuario que coincida con el indicado por el usuario le mostararemos un mensaje de error:
                return "El nombre ya se encuentra en uso. Por favor, utiliza otro.";
            
            } else {

                // Si el usuario consigue pasar nuestras comprobaciones, entonces le agregamos a la Newsletter a través de una consulta:
                $altaNewsletter = "INSERT INTO NEWSLETTER (nombre, email) VALUES (?, ?)";

                // Prepararemos la consulta:
                $stmtAltaNewsletter = $conexion->prepare($altaNewsletter);

                // Vincularemos los parámetros:
                $stmtAltaNewsletter->bind_param("ss", $nombre, $email);

                // Ejecutaremos la consulta:
                $stmtAltaNewsletter->execute();

                // Cerraremos la consulta:
                $stmtAltaNewsletter->close();
            }
        }
    }
?>