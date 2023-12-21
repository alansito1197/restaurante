<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/AdministradorDAO.php';
    include_once 'modelo/ProductoDAO.php';
    include_once 'modelo/PedidoDAO.php';

    class adminController{

        // Crearemos una función cuyo objetivo tenga mostrar las vistas que contienen el formulario para añadir un producto:
        public function solicitudCrearProducto(){

            include 'vistas/header.php';
            include 'vistas/panelCrearProducto.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función que nos sirva para agregar un producto en nuestra base de datos:
        public function crearProducto(){

            if (isset($_POST['agregarProducto'])){

                // Si el administrador pulsa el botón de enviar el formulario, recogeremos todos los datos de este:
            
                // Guardaremos que usuario ha enviado el formulario:
                $usuario_id = $_SESSION['usuario_id'];

                // Guardaremos cada campo del formulario:
                $nombre = $_POST['nombre'];
                $categoriaProducto = $_POST['categoriaProducto'];
                $sabor = $_POST['sabor'];
                $valorEnergetico = $_POST['calorias'];
                $precioSinEditar = $_POST['precio'];

                // Eliminaremos todos los carácteres que haya introducido menos los números, los puntos o las comas:
                $precioSinEditar = preg_replace("/[^0-9.,]/", "", $precioSinEditar);
                
                // Reemplazaremos la coma por un punto para que no de error en nuestra base de datos:
                $precioSinEditar = str_replace(',','.', $precioSinEditar);
                
                // Convertiremos el número resultante a decimal:
                $precio = floatval($precioSinEditar);
                
                $disponibilidad = $_POST['disponibilidad'];
                $stock = $_POST['stock'];
                $ingredientes = $_POST['ingredientes'];
                $productoDestacado = $_POST['productoDestacado'];
                $password = $_POST['password'];
                
                // Guardaremos la imagen y crearemos otra variable para almacenarla temporalmente antes de enviarla a su directorio correcto:
                $imagen = $_FILES['imagen']['name'];
                $imagen_tmp = $_FILES['imagen']['tmp_name'];

                // Trataremos de igual forma a la imagen que es la valoración del producto:
                $valoracion = $_FILES['valoracion']['name'];
                $valoracion_tmp = $_FILES['valoracion']['tmp_name'];

                // Indicaremos las rutas en las que deseamos depositar nuestras imagenes
                $rutaImagen = "assets/imagenes/productos/nuevo/" . $imagen;
                $rutaValoracion = "assets/imagenes/iconos/valoraciones/". $valoracion;
                
                // Moveremos las imagenes a las rutas que deseamos:
                move_uploaded_file($imagen_tmp, $rutaImagen);
                move_uploaded_file($valoracion_tmp, $rutaValoracion);

                // Recuperaremos la contraseña del administrador mediante la llamada del método que se encarga de ello:
                $contraseñaAlmacenada = AdministradorDAO::getPasswordAdmin($usuario_id);

                if ($contraseñaAlmacenada == $password) {

                    // Si la contraseña proporcionada por el administrador coincide con la que tenemos depositada en la base de datos, continuamos:

                    // Almacenaremos en una variable la llamada al archivo que contacta con la base de datos en lo que a productos se refiere:
                    $productoDAO = new ProductoDAO();

                    /* Utilizaremos la anterior variable para llamar al método en ProductoDAO que se encarga de agregar el producto a la base de datos
                    enviándole por parámetro la información aportada por el administrador: */
                    $productoDAO-> agregarProducto($usuario_id, $categoriaProducto, $nombre, $sabor, $valorEnergetico, $precio, $disponibilidad, $stock, $ingredientes, $productoDestacado, $rutaImagen, $rutaValoracion);

                    // Guardaremos en la variable que aparece en caso de agregar el producto con éxito la frase que se mostrará después del formulario:
                    $mensajeAcierto = "¡Producto agregado correctamente!";

                    // Incluiremos las vistas necesarias para que el administrador pueda agregar más de un producto sin salir de la vista:
                    include 'vistas/header.php';
                    include 'vistas/panelCrearProducto.php';
                    include 'vistas/footer.php';
                
                } else {

                    /* Si la contraseña indicada no coincide con la que tenemos en la base de datos, le mostraremos un mensaje de error en la vista
                    y incluiremos las vistas para que pueda volver a intentarlo: */

                    $mensajeError = "La contraseña no es correcta.";
                    include 'vistas/header.php';
                    include 'vistas/panelCrearProducto.php';
                    include 'vistas/footer.php';
                    
                }
            }
        }

        // Crearemos una función que se encargue de llamar al método que nos devuelve todos los productos y de mostrar el panel con todos los productos:
        public function solicitudGestionarProductos(){

            // Llamaremos al método que nos devuelve todos los productos de la web:
            $AllProductos = ProductoDAO::getAllProducts();

            // Incluiremos las vistas necesarias:
            include 'vistas/header.php';
            include 'vistas/panelGestionarProductos.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función que nos sirva para gestionar los productos, es decir, según que botón pulse el administrador, redirigirlo a la función correspondiente:
        public function gestionarProducto(){

            if(isset($_POST['modificar'])){

                // Si el administrador pulsa el botón de modificar, guardaremos el producto en una variable y lo enviaremos a la función que se encarga de mostrarle la vista de modificar:
                $idProducto = $_POST['modificar'];
                $this->modificarProducto($idProducto);
            
            }elseif(isset($_POST['eliminar'])){

                // Si el administrador pulsa el botón de eliminar, guardaremos el producto en una variable y lo enviaremos a la función que se encarga de mostrarle la vista de eliminar:
                $idProducto = $_POST['eliminar'];
                $this->eliminarProducto($idProducto);
            }
        }

        // Crearemos una función cuya utilidad sea obtener el producto actual para mostrarlo en la vista encargada de modificar dicho producto:
        public function modificarProducto($idProducto){

            // Almacenaremos en una variable la llamada al archivo que contacta con la base de datos en lo que a productos se refiere:
            $productoDAO = new ProductoDAO();

            // Guardaremos en una variable toda la información del producto gracias al método encargado de ello:
            $productoActual = $productoDAO::obtenerProductoByID($idProducto);

            // Incluiremos las vistas necesarias:
            include 'vistas/header.php';
            include 'vistas/panelModificarProducto.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuyo objetivo sea actualizar el producto deseado por el administrador:
        public function actualizarProductoSeleccionado(){

            // Almacenaremos en una variable únicamente el ID del producto extraído del input hidden del formulario:
            $id_producto =  $_POST['idProducto'];

            // Guardaremos en una variable el ID del administrador actual:
            $usuario_id = $_SESSION['usuario_id'];

            // Guardaremos en una variable toda la información del producto gracias al método encargado de ello:
            $productoActual = ProductoDAO::obtenerProductoByID($id_producto);

            if ($productoActual){

                // Si la llamada al método anterior ha devuelto true, continuamos:

                if (isset($_POST['modificarProducto'])){

                    /* Si la llamada al producto ha dado true y el administrador ha pulsado el botón de modificar el producto,
                    entonces guardaremos toda la información aportada por él en una variable */
                    $id_producto =  $_POST['idProducto'];
                    $nombre = $_POST['nombre'];
                    $sabor = $_POST['sabor'];
                    $valorEnergetico = $_POST['valorEnergetico'];
                    $precio = $_POST['precio'];
                    $disponibilidad = $_POST['disponibilidad'];
                    $stock = $_POST['stock'];
                    $ingredientes = $_POST['ingredientes'];
                    $productoDestacado = $_POST['productoDestacado'];
                    $password = $_POST['password'];

                    // Recuperaremos la contraseña del administrador mediante la llamada del método que se encarga de ello:
                    $contraseñaAlmacenada = AdministradorDAO::getPasswordAdmin($usuario_id);

                    if ($contraseñaAlmacenada == $password) {

                        /* Si la contraseña proporcionada por el administrador coincide con la que tenemos depositada en la base de datos, continuamos:
                        Llamaremos a la función que se encarga de actualizar el producto enviándole por parámetro la información que ha proporcionado: */
                        ProductoDAO::actualizarProducto($id_producto, $nombre, $sabor, $valorEnergetico, $precio, $disponibilidad, $stock, $ingredientes, $productoDestacado);
                        
                        // Volvemos a cargar el producto modificado, por si el administrador desea modificar otro campo antes de salir de la vista:
                        $productoActual = ProductoDAO::obtenerProductoByID($id_producto);

                        // Informaremos de que hemos podido modificar el producto:
                        $mensajeAcierto = "¡El producto se ha modificado correctamente!";

                        // Incluiremos las vistas necesarias para que el administrador pueda modificar otra vez el producto sin salir de la vista:
                        include 'vistas/header.php';
                        include 'vistas/panelModificarProducto.php';
                        include 'vistas/footer.php';
                    
                    } else {

                        // Informaremos de que la contraseña aportada es incorrecta:
                        $mensajeError = "Contraseña incorrecta.";

                        // Incluiremos las vistas necesarias para que el administrador pueda volver a intentarlo sin salir de la vista:
                        include 'vistas/header.php';
                        include 'vistas/panelModificarProducto.php';
                        include 'vistas/footer.php';
                    } 
                }
            }
        }

        // Crearemos una función cuya utilidad sea obtener el producto actual para mostrarlo en la vista encargada de eliminar dicho producto:
        public function eliminarProducto($idProducto){

            // Almacenaremos en una variable la llamada al archivo que contacta con la base de datos en lo que a productos se refiere:
            $productoDAO = new ProductoDAO();

            // Guardaremos en una variable toda la información del producto gracias al método encargado de ello:
            $productoActual = $productoDAO::obtenerProductoByID($idProducto);

            // Incluiremos las vistas necesarias:
            include 'vistas/header.php';
            include 'vistas/panelEliminarProducto.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuyo objetivo sea eliminar el producto deseado por el administrador:
        public function eliminarProductoSeleccionado(){

            // Almacenaremos en una variable únicamente el ID del producto extraído del input hidden del formulario:
            $id_producto = $_POST['idProducto'];

            // Guardaremos en una variable toda la información del producto gracias al método encargado de ello:
            $productoActual = ProductoDAO::obtenerProductoByID($id_producto);

            if (isset($_POST['eliminar'])) {

                // Si el administrador ha pulsado el boton de eliminar, continuamos:

                if ($productoActual) {

                    // Si la llamada al método anterior ha devuelto true, continuamos:
                    $id_producto = $_POST['idProducto'];

                    // Llamaremos al método que elimina el producto de la base de datos enviándole por parámetro el ID del producto:
                    ProductoDAO::eliminarProducto($id_producto);

                    // Una vez eliminado, redirigiremos al panel donde se nos muestra toda la lista de productos:
                    header("Location:".url."?controller=admin&action=solicitudGestionarProductos");
                } 
                
            } else {

                // Si ha pulsado el botón de cancelar, lo redirigiremos al panel que muestra todos los productos:
                header("Location:".url."?controller=admin&action=solicitudGestionarProductos");
            }
        }

        // Crearemos una función cuya finalidad sea mostrar todos los pedidos de nuestra web:
        public function solicitudGestionarPedidos(){

            // Llamaremos al método que nos devuelve todos los pedidos de la web:
            $AllPedidos = PedidoDAO::getAllPedidos();

            if (empty($AllPedidos)){

                // Si no tenemos pedidos en nuestra web, mostraremos la vista necesaria:
                include 'vistas/header.php';
                include 'vistas/panelSinPedidos.php';
                include 'vistas/footer.php';

            } else {

                // Si tenemos pedidos en nuestra web, mostraremos la vista necesaria:
                include 'vistas/header.php';
                include 'vistas/panelGestionarPedidos.php';
                include 'vistas/footer.php';
            }
        }

        // Crearemos una función que nos sirva para gestionar los pedidos, es decir, según que botón pulse el administrador, redirigirlo a la función correspondiente:
        public function gestionarPedido(){

            if(isset($_POST['modificar'])){

                // Si el administrador pulsa el botón de modificar, guardaremos el pedido en una variable y lo enviaremos a la función que se encarga de mostrarle la vista de modificar:
                $idPedido = $_POST['modificar'];
                $this->modificarPedido($idPedido);
            
            }elseif(isset($_POST['eliminar'])){

                // Si el administrador pulsa el botón de eliminar, guardaremos el pedido en una variable y lo enviaremos a la función que se encarga de mostrarle la vista de eliminar:
                $idPedido = $_POST['eliminar'];
                $this->eliminarPedido($idPedido);
            }
        }

        // Crearemos una función cuya utilidad sea obtener el pedido actual para mostrarlo en la vista encargada de modificar dicho producto:
        public function modificarPedido($idPedido){

            // Almacenaremos en una variable la llamada al archivo que contacta con la base de datos en lo que a productos se refiere:
            $pedidoDAO = new PedidoDAO();
    
            // Guardaremos en una variable toda la información del pedido gracias al método encargado de ello:
            $pedidoActual = $pedidoDAO::getPedidoByID($idPedido);
    
            // Incluiremos las vistas necesarias:
            include 'vistas/header.php';
            include 'vistas/panelModificarPedido.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función cuyo objetivo sea actualizar el pedido deseado por el administrador:
        public function actualizarPedidoSeleccionado() {
            
            // Almacenaremos en una variable únicamente el ID del pedido extraído del input hidden del formulario:
            $id_pedido = $_POST['idPedido'];
        
            // Guardamos en una variable el ID del administrador actual:
            $usuario_id = $_SESSION['usuario_id'];
            
            // Guardamos en una variable toda la información del pedido gracias al método encargado de ello:
            $pedidoActual = PedidoDAO::getPedidoByID($id_pedido);
            
            if ($pedidoActual) {
                // Si la llamada al método anterior ha devuelto true, continuamos:
        
                if (isset($_POST['modificarPedido'])) {
                    // Si el administrador ha pulsado el botón de modificar el pedido, guardamos toda la información aportada por él en una variable
                    $id_cliente = $_POST['idCliente'];
                    $tipoUsuario = $_POST['tipoUsuario'];
                    $precioTotal = $_POST['precioTotal'];
                    $fecha = $_POST['fecha'];
                    $estado = $_POST['estado'];
                    $password = $_POST['password'];
            
                    // Recuperamos la contraseña del administrador mediante la llamada del método que se encarga de ello:
                    $contraseñaAlmacenada = AdministradorDAO::getPasswordAdmin($usuario_id);
            
                    if ($contraseñaAlmacenada == $password) {

                        // Si la contraseña proporcionada por el administrador coincide, continuamos:
                        
                        // Llamamos a la función que se encarga de actualizar el pedido
                        PedidoDAO::actualizarPedido($id_pedido, $id_cliente, $tipoUsuario, $precioTotal, $fecha, $estado);
                        
                        // Volvemos a cargar el producto modificado
                        $pedidoActual = PedidoDAO::getPedidoByID($id_pedido);

                        // Informamos que hemos podido modificar el pedido
                        $mensajeAcierto = "¡El pedido se ha modificado correctamente!";
            
                        // Incluimos las vistas necesarias
                        include 'vistas/header.php';
                        include 'vistas/panelModificarPedido.php';
                        include 'vistas/footer.php';
                    } else {
                        // Informamos que la contraseña proporcionada es incorrecta
                        $mensajeError = "Contraseña incorrecta.";
            
                        // Incluimos las vistas necesarias
                        include 'vistas/header.php';
                        include 'vistas/panelModificarPedido.php';
                        include 'vistas/footer.php';
                    }
                }
            }
        }

        // Crearemos una función cuya utilidad sea obtener el pedido actual para mostrarlo en la vista encargada de eliminar dicho producto:
        public function eliminarPedido($idPedido){

            // Almacenaremos en una variable la llamada al archivo que contacta con la base de datos en lo que a productos se refiere:
            $pedidoDAO = new PedidoDAO();

            // Guardaremos en una variable toda la información del pedido gracias al método encargado de ello:
            $pedidoActual = $pedidoDAO::getPedidoByID($idPedido);

            // Incluiremos las vistas necesarias:
            include 'vistas/header.php';
            include 'vistas/panelEliminarPedido.php';
            include 'vistas/footer.php';
        }

        // Crearemos una función para eliminar el pedido que desee el administrador:
        public function eliminarPedidoSeleccionado(){

            // Almacenaremos en una variable únicamente el ID del pedido extraído del input hidden del formulario:
            $id_pedido = $_POST['idPedido'];

            // Guardaremos en una variable toda la información del pedido gracias al método encargado de ello:
            $pedidoActual = PedidoDAO::getPedidoByID($id_pedido);
    
            if (isset($_POST['eliminar'])) {
    
                // Si el administrador ha pulsado el boton de eliminar, continuamos:
    
                if ($pedidoActual) {
    
                    // Si la llamada al método anterior ha devuelto true, continuamos:
                    $id_pedido = $_POST['idPedido'];
    
                    // Llamaremos al método que elimina el pedido de la base de datos enviándole por parámetro el ID del producto:
                    PedidoDAO::eliminarPedido($id_pedido);
    
                    // Una vez eliminado, redirigiremos al panel donde se nos muestra toda la lista de pedidos:
                    header("Location:".url."?controller=admin&action=solicitudGestionarPedidos");
                } 
                    
            } else {
    
                // Si ha pulsado el botón de cancelar, lo redirigiremos al panel que muestra todos los pedidos:
                header("Location:".url."?controller=admin&action=solicitudGestionarPedidos");
            }
        }
    }
?>