<?php

    include_once 'config/dataBase.php';

    class UsuarioDAO {

        public function getBuscarUsuario($email) {
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una variable para comprobar si el email introducido por el usuario es un cliente:
            $busquedaCredencialCliente = "SELECT cliente.id_cliente AS ID, cliente.email, credencial.tipo_usuario, credencial.password
                                          FROM CLIENTE cliente
                                          JOIN CREDENCIAL credencial ON cliente.id_cliente = credencial.id_cliente
                                          WHERE credencial.tipo_usuario = 'cliente' AND cliente.email = ?";
        
            // Crearemos una variable para comprobar si el email introducido por el usuario es un empleado:
            $busquedaCredencialAdministrador = "SELECT administrador.id_administrador AS ID, administrador.email, credencial.tipo_usuario, credencial.password
                                                FROM ADMINISTRADOR ADMINISTRADOR
                                                JOIN CREDENCIAL credencial ON administrador.id_administrador = credencial.id_administrador
                                                WHERE credencial.tipo_usuario = 'administrador' AND administrador.email = ?";
        
            // Preparar y ejecutar consulta para cliente
            $stmtCliente = $conexion->prepare($busquedaCredencialCliente);
            $stmtCliente->bind_param("s", $email);
            $stmtCliente->execute();
        
            // Obtener resultados para cliente
            $resultadoCliente = $stmtCliente->get_result();
        
            if ($resultadoCliente->num_rows > 0) {
                // Si encontramos algún registro que coincida con el cliente, guardamos dicho objeto en una variable:
                $credencial = $resultadoCliente->fetch_object('Cliente');
                $stmtCliente->close();
            } else {
                // Cerrar la consulta para cliente
                $stmtCliente->close();
        
                // Preparar y ejecutar consulta para administrador
                $stmtAdministrador = $conexion->prepare($busquedaCredencialAdministrador);
                $stmtAdministrador->bind_param("s", $email);
                $stmtAdministrador->execute();
        
                // Obtener resultados para administrador
                $resultadoAdministrador = $stmtAdministrador->get_result();
        
                if ($resultadoAdministrador->num_rows > 0) {
                    // Si encontramos algún registro que coincida con el administrador, guardamos dicho objeto en una variable:
                    $credencial = $resultadoAdministrador->fetch_object('Administrador');
                }
        
                // Cerrar la consulta para administrador
                $stmtAdministrador->close();
            }
        
            return $credencial;
        }
        
    }
?>