<?php

    session_start();

    include_once 'config/dataBase.php';
    include_once 'modelo/UsuarioDAO.php';

    class userController{
        
        // Crearemos una función que se encargue de comprobar si el usuario ha iniciado sesión, con el objetivo de redirigirlo a un panel u a otro:
        public function login(){
            
            // Verificamos si existen las variables de inicio de sesión
            if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre']) || !isset($_SESSION['password'])) {
                
                // Redirigimos al usuario a la página de iniciar sesión si no existen las variables de inicio de sesión
                include 'vistas/header.php';
                include 'vistas/panelInicioSesion.php';
                include 'vistas/footer.php';
                exit();

            } else {

                // Verificamos el tipo de usuario
                if ($_SESSION['tipo_usuario'] == 'administrador') {

                    // Si el usuario es un administrador, lo redirigimos al panel de administrador
                    include 'vistas/header.php';
                    include 'vistas/panelAdministrador.php';
                    include 'vistas/footer.php';

                } elseif ($_SESSION['tipo_usuario'] == 'cliente') {
                    // Si el usuario es un cliente, lo redirigimos al panel de cliente
                    include 'vistas/header.php';
                    include 'vistas/panelCliente.php';
                    include 'vistas/footer.php';
                } 
            }
        }

        // Crearemos una función que se encargue de gestionar el inicio de sesión de un usuario a nuestra web:
        public function comprobarUsuario() {

            if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre']) && isset($_SESSION['password']) && isset($_SESSION['tipo_usuario'])) {
                
                // El usuario ya ha iniciado sesión, redirigimos al panel correspondiente
                include 'vistas/header.php';
                
                if ($_SESSION['tipo_usuario'] == 'administrador') {
                    
                    include 'vistas/panelAdministrador.php';
                
                } elseif ($_SESSION['tipo_usuario'] == 'cliente') {
            
                    include 'vistas/panelCliente.php';
                }
        
                include 'vistas/footer.php';
            
            } else {

                if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
        
                    $email = $_POST['usuario'];
                    $password = $_POST['password'];
        
                    $clienteDAO = new ClienteDAO();
                    $credencial = $clienteDAO->getUsuarioPorEmail($email);
        
                    if ($credencial !== null) {
        
                        if ($password == $credencial->password) {
        
                            session_start();
                            $_SESSION['usuario_id'] = $credencial->ID;
                            $_SESSION['tipo_usuario'] = $credencial->tipo_usuario;
                            $_SESSION['usuario_nombre'] = $email;
                            $_SESSION['password'] = $password;
                            header('Location:'.url.'?controller=user&action=login');
                            exit();
                            
                        } else {
        
                            // Mostrar mensaje de contraseña incorrecta
                            $mensaje_error = "Contraseña incorrecta.";
                        }
        
                    } else {
        
                        // Mostrar mensaje de usuario no encontrado
                        $mensaje_error = "Usuario no encontrado.";
                    }
        
                } else {
        
                    // Mostrar mensaje de formulario incompleto
                    $mensaje_error = "Por favor, completa todos los campos.";
                }
        
               // Mostrar el formulario con el mensaje de error
                include 'vistas/header.php';
                include 'vistas/panelInicioSesion.php';
                include 'vistas/footer.php';
            }
        }
        

        // Crearemos una función cuyo objetivo sea cerrar la sesión actual del usuario:
        public function logout(){

            // Cerraremos la sesión y redirigiremos a la función que comprobará si el usuario se encuentra con sesión activa:
            session_start();
            session_destroy();
            header('Location:'.url.'?controller=user&action=login');
            $_SESSION = array();
        }
    }
?>