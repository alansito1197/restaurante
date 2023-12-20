<?php

    session_start();

    include_once 'config/dataBase.php';
    include_once 'modelo/usuarioDAO.php';

    class userController {

        // Crearemos una función que se encargue de controlar el inicio de sesión del usuario, con el objetivo de redirigirlo a un panel u otro:
        public function login(){

            // Verificamos si no existen las variables de inicio de sesión que se crean al iniciar sesión:
            if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['password']) || !isset($_SESSION['usuario_nombre']) || !isset($_SESSION['tipo_usuario'])) {

                // Redirigiremos al usuario a la página de inicio de sesión en el caso de que estas no existan:
                include 'vistas/header.php';
                include 'vistas/panelInicioSesion.php';
                include 'vistas/footer.php';
                exit();
            
            } else {

                // En el caso de que las variables de inicio de sesión existan, comprobaremos el tipo de usuario que es:
                if ($_SESSION['tipo_usuario'] == 'administrador'){

                    // Si el usuario es un administrador, le mostraremos los paneles de administrador:
                    include 'vistas/header.php';
                    include 'vistas/panelAdministrador.php';
                    include 'vistas/footer.php';

                } elseif ($_SESSION['tipo_usuario'] == 'cliente'){

                    // Si el usuario es un cliente, le mostaremos los paneles de cliente:
                    include 'vistas/header.php';
                    include 'vistas/panelCliente.php';
                    include 'vistas/footer.php';
                }
            }
        }

        // Crearemos una función que se encargue de gestionar cuando un usuario rellena el formulario de inicio de sesión:
        public function comprobarUsuario(){

            if(isset($_SESSION['usuario_id']) && ($_SESSION['usuario_nombre']) && ($_SESSION['password']) && ($_SESSION['tipo_usuario'])){

                // Si el usuario ha iniciado sesión previamente, redirigimos al panel correspondiente:
                include 'vistas/header.php';

                if ($_SESSION['tipo_usuario'] == 'administrador'){

                    include 'vistas/panelAdministrador.php';
                
                } elseif ($_SESSION['tipo_usuario'] == 'cliente'){

                    include 'vistas/panelCliente.php';
                }

                include 'vistas/footer.php';
            
            } else {

                if (!empty($_POST['usuario']) && !empty($_POST['password'])){

                    // Si el usuario no ha iniciado sesión previamente y ha rellenado el formulario de inicio de sesión, guardaremos su información en variables:
                    $email = $_POST['usuario'];
                    $password = $_POST['password'];

                    // Crearemos una nueva instancia:
                    $usuarioDAO = new UsuarioDAO();

                    // Guardaremos en una variable la llamada al método que busca si el email introducido ya se encuentra en la base de datos:
                    $usuario = $usuarioDAO->getBuscarUsuario($email);

                    if ($usuario !== null){

                        // Si se encuentra a un usuario con el email introducido en la base de datos, continuamos:
                        
                        if ($password == $usuario->password) {

                            /* Si la contraseña introducida es igual al campo llamado password de nuestro usuario encontrado:
                            Iniciamos la sesión, guardamos en variables de sesión la información que nos interesa y lo redirigimos a la función
                            que le mostrará su panel */
                            session_start();
                            $_SESSION['usuario_id'] = $usuario->ID;
                            $_SESSION['usuario_nombre'] = $email;
                            $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;
                            $_SESSION['password'] = $password;
                            header('Location:'.url.'?controller=user&action=login');
                            exit();
                        
                        } else {

                            // Si la contraseña es incorrecta, mostraremos un mensaje de error:
                            $mensajeError = "Contraseña incorrecta.";
                        }

                    } else {

                        // Si no encontramos un usuario, mostraremos un mensaje de error:
                        $mensajeError = "Usuario no encontrado.";
                    }

                } else {

                    // Si el usuario no ha rellenado todo el formulario, mostraremos un mensaje de error:
                    $mensajeError = "Por favor, completa todos los campos.";
                }

                // Incluiremos las vistas con el mensaje de error:
                include 'vistas/header.php';
                include 'vistas/panelInicioSesion.php';
                include 'vistas/footer.php';
            }
        }

        // Crearemos una función cuyo objetivo sea cerrar la sesión actual del usuario:
        public function logout(){

            // Borraremos las variables de sesión:
            session_start();
            session_destroy();

            // Eliminaremos la cookie:
            $usuario_id = $_SESSION['usuario_id'];
            setcookie('CookieUltimoPedido_' . $usuario_id, '', time() - 3600);

            // Redirigiremos a la función que le mostrará el panel necesario:
            header('Location:'.url.'?controller=user&action=login');
            $_SESSION = array();
        }
    }
?>