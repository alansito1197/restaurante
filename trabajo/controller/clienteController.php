<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/ClienteDAO.php';

    class clienteController{

        // Crearemos una función cuyo objetivo sea solicitar la autorización para modificar los datos de la cuenta del usuario:
        public function solicitudModificacionCuenta() {
            
            // Guardaremos el ID del usuario actual en una variabble:
            $usuario_id = $_SESSION['usuario_id'];

            /* Recuperaremos todos los datos del actual usuario gracias a la llamada de una función que se encarga de ello
            con el objetivo de rellenar los placeholders del formulario de modificación de cuenta: */

            $clienteActual = UsuarioDAO::getUsuarioByID($usuario_id);
        
            include 'vistas/header.php';
            include 'vistas/panelModificarCuenta.php';
            include 'vistas/footer.php';       
        }

        // Crearemos una función que modifique los valores de la cuenta del cliente:
        public function modificacionCuenta() {

            // Guardaremos el ID del usuario actual en una variable:
            $usuario_id = $_SESSION['usuario_id'];

            // Cargaremos la información del cliente actual llamándo al método que se encarga de recuperar dichos datos:
            $clienteActual = UsuarioDAO::getUsuarioByID($usuario_id);
            
            if ($clienteActual) {

                // Si se obtuvieron los datos del cliente actual correctamente, entonces:
                if (isset($_POST['modificar_cliente'])) {

                    // Si el cliente pulso el botón de modificar, guardaremos la información aportada en una variable:
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $direccion = $_POST['direccion'];
                    $email = $_POST['email'];
                    $telefono = $_POST['telefono'];
                    $password = $_POST['password'];

                    // Obtendremos la contraseña del cliente en la base de datos mediante la llamada del método que se encarga de recuperarla:
                    $contrasena_almacenada = ClienteDAO::obtenerPasswordCliente($usuario_id);
            
                    if ($contrasena_almacenada !== null && $password == $contrasena_almacenada) {

                        // Si la contraseña en la base de datos no es nula y coincide con la aportada por el cliente en el formulario:
                        if (ClienteDAO::actualizarDatosCliente($usuario_id, $nombre, $apellidos, $direccion, $email, $telefono)) {

                            /* Modificamos al usuario gracias a la llamada a la función que se encarga de ello enviándole por parámetro la información
                            aportada por el cliente, y lo redirigiremos a la misma página por si quisiera volver a modificar otra vez: */
                            
                            header('Location:'.url.'?controller=cliente&action=solicitudModificacionCuenta');
                            exit();

                        } 

                    } else {
                        
                        // Mostrar mensaje de contraseña incorrecta
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
                
            // Verificaremos que quien intenta eliminar su cuenta tiene permisos para hacerlo, es decir, si es un cliente:
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
                $resultado_eliminacion = $cliente->eliminarCuenta($id_cliente);
        
                if ($resultado_eliminacion) {

                    /* Si conseguimos eliminar la cuenta, destruiremos las variables de sesión y redirigiremos a la función que comprueba si hay sesión activa
                    con el objetivo que muestre el panel de registro de nuevo. */

                    session_destroy();
                    header('Location:'.url.'?controller=user&action=login');
                    exit();

                } 

            

            // Redirigimos en caso de error o si no hay sesión iniciada:
            header('Location:'.url.'?controller=user&action=login');
            exit();

            }
        }

        // Crearemos una función cuya finalidad sea llamar a la vista que permita darse de alta en nuestra web:
        public function solicitudRegistro(){

            include 'vistas/header.php';
            include_once 'vistas/panelRegistro.php';
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
                    $nuevo_cliente = new UsuarioDAO();
        
                    // Verificaremos si el email introducido ya se encuentra registrado previamente gracias a la llamada del método que nos obtiene todos los correos:
                    $usuario_existente = $nuevo_cliente->getUsuarioPorEmail($email, UsuarioDAO::conectarBaseDeDatos());

                    if ($usuario_existente) {

                        // Si el usuario ya se encuentra registrado previamente, daremos un mensaje por pantalla y redirigiremos a la acción que muestra la vista de la solicitud de registro:
                        
                        $mensaje_error = "El usuario introducido ya existe.";
                    }
        
                    // Registraremos al nuevo cliente gracias a la llamada del uso de la función que se encarga de ello, pasándole por parámetro la información aportada por él:
                    $id_cliente = $nuevo_cliente->registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password);
        
                    // Además, guardaremos la información que nos interesa del cliente en variables de sesión:
                    $_SESSION['usuario_id'] = $id_cliente;
                    $_SESSION['tipo_usuario'] = 'cliente';
                    $_SESSION['usuario_nombre'] = $email;
                    $_SESSION['password'] = $password;
        
                    // Para finalizar, mostraremos un mensaje de registro exitoso y redirigiremos a la función que te comprueba si hay sesión activa:
                    header('Location:'.url.'?controller=user&action=login');

                } else {

                    /* En el caso de que las contraseñas no coincidan, mostraremos por pantalla un mensaje de error y redireccionaremos a la función que muestra
                    la vista que te permite registrarte */

                    // Mostrar mensaje de contraseña incorrecta
                    $mensaje_error = "Contraseña incorrecta.";
                    
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
                $resultado = $clienteDAO->comprobarSuscripcionNewsletter($nombre, $email);
        
                if ($resultado === "success") {

                    /* Si el valor de la variable resultado es exactamente success, imprimiremos un mensaje por pantalla dándole
                    la bienvenida al usuario y lo redireccionaremos a la página principal */

                    echo '<script>alert("¡Se ha dado de alta al usuario ' . $nombre . '! ¡Bienvenido!");';
                    echo 'window.location.href="'.url.'?controller=producto&action=index";</script>';

                } else {

                    // Si el valor de la variable resultado no es exactamente success, mostraremos el valor de la variable resultado:
                    echo '<script>alert("' . $resultado . '");';
                    echo 'window.location.href="'.url.'?controller=producto&action=index";</script>';
                }
            }
        }
    }
?>