<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/ClienteDAO.php';

    class clienteController {

        // Crearemos una función cuyo objetivo sea obtener los datos del cliente que desea modificar sus datos y mostrar la vista que le mostrará el formulario a rellenar:
        public function solicitudModificacionCuenta() {

            // Obtenemos el ID del usuario que tiene la sesión activa:
            $usuario_id = $_SESSION['usuario_id'];

            // Guardaremos en una variable la información del cliente en cuestión:
            $cliente = ClienteDAO::getUsuarioByID($usuario_id);

            // Incluiremos las vistas necesarias para que el cliente puede modificar sus datos:
            include 'vistas/header.php';
            include 'vistas/panelModificarCuenta.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuyo objetivo sea modificar los datos del cliente:
        public function modificacionCuenta(){

            // Obtenemos el ID del usuario que tiene la sesión activa:
            $cliente_id = $_SESSION['usuario_id'];

            // Guardaremos en una variable la información del cliente en cuestión:
            $clienteActual = ClienteDAO::getUsuarioByID($cliente_id);

            // Definiremos dos variables como vacías ya que más tarde las necesitaremos:
            $mensaje_acierto = "";
            $mensaje_error = "";

            if ($clienteActual) {

                // Si la llamada al método anterior ha devuelto true, continuamos:

                if (isset($_POST['modificarCliente'])) {

                    // Si el cliente ha pulsado el botón de modificar sus datos, continuamos:

                    // Guardamos toda la información aportada en una variable:
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $direccion = $_POST['direccion'];
                    $email = $_POST['email'];
                    $telefono = $_POST['telefono'];
                    $password = $_POST['password'];

                    // Llamaremos al método que nos devuelve la contraseña del cliente:
                    $contraseñaAlmacenada = ClienteDAO::getPasswordCliente($cliente_id);

                    if ($password == $contraseñaAlmacenada){

                        // Si la contraseña proporcionada por el cliente coincide con la que tenemos guardada en la base de datos, continuamos:

                        // Llamaremos al método que contacta con la base de datos y actualiza los datos del cliente pasándole por parámetro la información aportada por este:
                        ClienteDAO::actualizarDatosCliente($cliente_id, $nombre, $apellidos, $direccion, $email, $telefono);

                        

                        // Avisaremos al cliente de que hemos podido modificar sus datos:
                        $mensajeAcierto = "¡Los datos se han modificado correctamente!";

                        // Cargaremos nuevamente los datos del cliente por si este quisiera modificar más información:
                            $cliente = ClienteDAO::getUsuarioById($cliente_id);

                        // Incluiremos las vistas necesarias por si deseara modificar otro campo:
                        include 'vistas/header.php';
                        include 'vistas/panelModificarCuenta.php';
                        include 'vistas/footer.php';
                    
                    } else {

                        // Si la contraseña proporcionada no coincide con la que tenemos en la base de datos:

                        // Cargaremos nuevamente la información del cliente para que vuelva a intentarlo:
                        $cliente = ClienteDAO::getUsuarioByID($cliente_id);

                        // Le mostraremos por pantalla un mensaje de aviso:
                        $mensajeError = "Contraseña incorrecta.";

                        // Incluiremos las vistas necesarias para que vuelva a intentarlo:
                        include 'vistas/header.php';
                        include 'vistas/panelModificarCuenta.php';
                        include 'vistas/footer.php';
                    }
                }
            }
        }

        // Crearemos una función cuyo objetivo sea obtener los datos del cliente que desea eliminar su cuenta y mostrar la vista que le mostrará el aviso::
        public function solicitudEliminacionCuenta(){

            // Guardaremos al cliente actual en una variable utilizando la que tenemos de sesión:
            $cliente_id = $_SESSION['usuario_id'];

            // Incluiremos las vistas necesarias para que pueda eliminar su cuenta:
            include 'vistas/header.php';
            include 'vistas/panelEliminarCuenta.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuya finalidad sea eliminar la cuenta del cliente, así como todos los datos relacionados a este:
        public function eliminacionCuenta(){

            if (isset($_SESSION['usuario_id'])) {

                // Guardaremos al cliente actual en una variable utilizando la que tenemos de sesión:
                $cliente_id = $_SESSION['usuario_id'];

                // Crearemos una nueva instancia:
                $cliente = new ClienteDAO();

                // Utilizaremos esta instancia para llamar a la función encargada de eliminar la cuenta enviándole por parámetro el ID del cliente:
                $cliente->eliminarCuenta($cliente_id);

                // Borraremos las variables de sesión y redirigiremos a la función que le mostrará el panel de inicio de sesión:
                session_destroy();
                header('Location:'.url.'?controller=user&action=login');
                exit();
            }
        }

        // Crearemos una función cuya finalidad sea llamar a las vistas que permiten registrarse en nuestra web:
        public function solicitudRegistro(){

            include 'vistas/header.php';
            include 'vistas/panelRegistro.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuyo objetivo será gestionar el registro o su intento de un cliente en nuestra web:
        public function registrarCliente(){

            if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['direccion'], $_POST['email'], $_POST['telefono'], $_POST['password'], $_POST['confirmacionPassword'])){

                // Si el cliente ha rellenado todo el formulario, guardaremos la información aportada en una variable:
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $direccion = $_POST['direccion'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                $password = $_POST['password'];
                $confirmacionPassword = $_POST['confirmacionPassword'];

                if ($password === $confirmacionPassword) {

                    // Si las contraseñas que nos aporta el cliente coinciden, seguimos comprobando:

                    // Crearemos una nueva instancia:
                    $nuevoCliente = new ClienteDAO();

                    // Verificaremos si el email introducido ya se encuentra registrado previamente gracias a la llamada del método que nos obtiene todos los correos de la web:
                    $usuarioExistente = $nuevoCliente->getUsuarioExistente($email);

                    if ($usuarioExistente) {

                        /* Si la llamada al método anterior devuelve true, significará que el email con el que desea registrarse ya se encuentra en nuestra
                        base de datos, por lo tanto, mostraremos un mensaje de error por pantalla y incluiremos a las vistas de registro de nuevo para que vuelva a intentarlo: */
                        
                        
                        $mensajeError = "El usuario introducido ya existe.";
                        include 'vistas/header.php';
                        include 'vistas/panelRegistro.php';
                        include 'vistas/footer.php';
                    
                    } else {

                        // Si la llamada al método anterior devuelve false, significará que podemos registrar al cliente:

                        // Registraremos al nuevo cliente gracias a la llamada del uso de la función que se encarga de ello, enviándole por parámetro la información aportada por él:
                        $cliente_id = $nuevoCliente->registrarCliente($nombre, $apellidos, $direccion, $email, $telefono, $password);   
                        
                        // Además, guardaremos la información que nos intersa del cliente en variables de sesión:
                        $_SESSION['usuario_id'] = $cliente_id;
                        $_SESSION['tipo_usuario'] = 'cliente';
                        $_SESSION['usuario_nombre'] = $email;
                        $_SESSION['password'] = $password;

                        // Para finalizar, redirigiremos a la función que comprobará si tienen sesión activa:
                        header('Location:'.url.'?controller=user&action=login');
                    }

                } else {

                    // En el caso de que las contraseñas no coincidan, mostraremos por pantalla un mensaje de error y redireccionaremos a la vista para que vuelva a probar:
                    $mensajeError = "Las contraseñas no coinciden.";
                    include 'vistas/header.php';
                    include 'vistas/panelRegistro.php';
                    include 'vistas/footer.php';
                }
            }
        }

        // Crearemos una función cuyo objetivo sea gestionar nuestra Newsletter:
        public function comprobarNewsletter(){

            if (!empty($_POST['email']) && !empty($_POST['nombre'])) {
        
                // Si el usuario rellena todos los campos de la Newsletter, guardamos la información introducida en una variable:
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];

                // Crearemos una nueva instancia:
                $clienteDAO = new ClienteDAO();

                // Llamaremos al método que comprobará si la suscripción es válida o no lo es:
                $clienteDAO->comprobarSuscripcionNewsletter($nombre, $email);

                header('Location:'.url.'?controller=producto&action=index');
            }
        }
    }
?>