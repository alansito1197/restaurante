<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/ClienteDAO.php';

    class clienteController{

        // Crearemos una función cuyo objetivo sea solicitar la autorización para modificar los datos de la cuenta del usuario:
        public function solicitudModificacionCuenta() {
            $usuario_id = $_SESSION['usuario_id'];
            $cliente = ClienteDAO::getUsuarioByID($usuario_id);
        
            include 'vistas/header.php';
            include 'vistas/panelModificarCuenta.php';
            include 'vistas/footer.php';
        }

        public function modificacionCuenta() {

            $usuario_id = $_SESSION['usuario_id'];
            $clienteActual = ClienteDAO::getUsuarioByID($usuario_id);
            
            $mensaje_acierto = "";
            $mensaje_error = "";
            
            if ($clienteActual) {

                if (isset($_POST['modificar_cliente'])) {
                        
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $direccion = $_POST['direccion'];
                    $email = $_POST['email'];
                    $telefono = $_POST['telefono'];
                    $password = $_POST['password'];
            
                    $contrasena_almacenada = ClienteDAO::getPasswordCliente($usuario_id);
            
                    if ($password == $contrasena_almacenada) {
                            
                        ClienteDAO::actualizarDatosCliente($usuario_id, $nombre, $apellidos, $direccion, $email, $telefono);
                        
                        // Cargamos nuevamente los datos del cliente:
                        $cliente = ClienteDAO::getUsuarioByID($usuario_id);    
                        $mensaje_acierto = "¡Los datos se han modificado correctamente!";
                        include 'vistas/header.php';
                        include 'vistas/panelModificarCuenta.php';
                        include 'vistas/footer.php';
                                
                             
                    } else {

                        // Cargamos nuevamente los datos del cliente:
                        $cliente = ClienteDAO::getUsuarioByID($usuario_id);   
                        $mensaje_error = "Contraseña incorrecta.";
                        include 'vistas/header.php';
                        include 'vistas/panelModificarCuenta.php';
                        include 'vistas/footer.php';
                    }
                }
            }
        }
            
        // Crearemos una función cuyo objetivo será mostrar la vista del panel para la eliminación de la cuenta:
        public function solicitudEliminacionCuenta() {

            // Guardaremos al usuario actual en una variable:
            $usuario_id = $_SESSION['usuario_id'];
            
            include 'vistas/header.php';
            include 'vistas/panelEliminarCuenta.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuya finalidad sea eliminar la cuenta del cliente:
        public function EliminacionCuenta() {

            if (isset($_SESSION['usuario_id'])) {
        
                // Guardaremos al usuario actual en una variable gracias a la variable de sesión:
                $id_cliente = $_SESSION['usuario_id'];
                
                // Creamos una nueva instancia:
                $cliente = new ClienteDAO();
        
                // Guardaremos en una variable si hemos encontrado una cuenta asociada a la del cliente que quiere eliminar su cuenta:
                $cliente->eliminarCuenta($id_cliente);

                session_destroy();
                // Redirigimos en caso de error o si no hay sesión iniciada:
                header('Location:'.url.'?controller=user&action=login');
                exit();
            }
        }

        // Crearemos una función cuya finalidad sea llamar a la vista que permita darse de alta en nuestra web:
        public function solicitudRegistro(){

            include 'vistas/header.php';
            include 'vistas/panelRegistro.php';
            include 'vistas/footer.php';
        }

        public function registrarCliente() {

            if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['direccion'], $_POST['email'], $_POST['telefono'], $_POST['password'], $_POST['confirmacion_password'])) {
                
                // Si el cliente ha rellenado todo el formulario, guardaremos la información aportada en una variable:
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $direccion = $_POST['direccion'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                $password = $_POST['password'];
                $confirmacion_password = $_POST['confirmacion_password'];
        
                // Si las contraseñas que nos aporta el cliente coinciden, seguiremos comprobando:
                if ($password === $confirmacion_password) {

                    // Crearemos una nueva instancia:
                    $nuevo_cliente = new ClienteDAO();
        
                    // Verificaremos si el email introducido ya se encuentra registrado previamente gracias a la llamada del método que nos obtiene todos los correos:
                    $usuario_existente = $nuevo_cliente->getUsuarioPorEmail($email);

                    if ($usuario_existente) {

                        // Si el usuario ya se encuentra registrado previamente, daremos un mensaje por pantalla y redirigiremos a:
                        $mensaje_error = "El usuario introducido ya existe.";
                        include 'vistas/header.php';
                        include 'vistas/panelRegistro.php';
                        include 'vistas/footer.php';

                    }else{
        
                        // Registraremos al nuevo cliente gracias a la llamada del uso de la función que se encarga de ello, pasándole por parámetro la información aportada por él:
                        $id_cliente = $nuevo_cliente->registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password);
            
                        // Además, guardaremos la información que nos interesa del cliente en variables de sesión:
                        $_SESSION['usuario_id'] = $id_cliente;
                        $_SESSION['tipo_usuario'] = 'cliente';
                        $_SESSION['usuario_nombre'] = $email;
                        $_SESSION['password'] = $password;
            
                        // Para finalizar, redirigiremos a la función que te comprueba si hay sesión activa:
                        header('Location:'.url.'?controller=user&action=login');
                    }

                } else {

                    /* En el caso de que las contraseñas no coincidan, mostraremos por pantalla un mensaje de error y redireccionaremos a la función que muestra
                    la vista que te permite registrarte */

                    // Mostrar mensaje de contraseña incorrecta
                    $mensaje_error = "Las contraseñas no coinciden.";
                    include 'vistas/header.php';
                    include 'vistas/panelRegistro.php';
                    include 'vistas/footer.php';
                } 
            }
        }
        
        // Crearemos una función cuyo objetivo sea gestionar nuestra Newsletter:
        public function comprobarNewsletter() {

            if (!empty($_POST['email']) && !empty($_POST['nombre'])) {

                // Si el usuario rellena todos los campos de la Newsletter, guardamos los valores introducidos en una variable:
                $nombre = $_POST["nombre"];
                $email = $_POST["email"];

                // Creamos una nueva instancia:
                $clienteDAO = new ClienteDAO();

                // Guardaremos en una variable el resultado de la llamada a la función que comprueba si el intento de registro es exitoso:
                $clienteDAO->comprobarSuscripcionNewsletter($nombre, $email);

                header('Location:'.url.'?controller=producto&action=index');
            }
        }
    }
?>