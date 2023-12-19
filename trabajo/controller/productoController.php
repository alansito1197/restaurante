<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/ProductoDAO.php';
    include_once 'modelo/CategoriaDAO.php';
    include_once 'utils/calculadoraPrecios.php';

    class productoController {   

        // Crearemos una función para la página de productos:
        public function productos(){

            // Llamaremos a la función que devuelve todos los productos de la base de datos:
            $AllProductos = ProductoDAO::getAllProducts();
            
            // Incluiremos las vistas necesarias:
            include_once 'vistas/header.php';
            include_once 'vistas/panelProductos.php'; 
            include_once 'vistas/footer.php';
        }

        // Crearemos una función cuya utilidad es gestionar el producto que añadimos al carrito:
        public function añadirCarrito() {

            // Verificamos si la sesión 'productosSeleccionados' está configurada, en caso negativo, crearemos la variable de sesión donde almacenaremos los productos seleccionados por el cliente:
            if (!isset($_SESSION['productosSeleccionados'])) {
                $_SESSION['productosSeleccionados'] = array();
            }
        
            // Obtendremos el ID del producto desde el formulario:
            $producto_id = $_POST['id_producto'];
        
            // Crearemos una variable que nos ayudará a verificar si el producto ya se encontraba en el carrito
            $enCarrito = false;
        
            // Mediante un bucle, buscaremos si el producto que intentamos añadir ya se encontraba previamente en él:
            foreach ($_SESSION['productosSeleccionados'] as $pedidoSerialized) {
                
                // Deserializamos el pedido:
                $pedido = unserialize($pedidoSerialized);
        
                if ($pedido->getProducto()->getIdProducto() == $producto_id) {

                    // En el caso de que el producto ya se encontrase previamente en el carrito, la variable pasaría a ser cierta:
                    $enCarrito = true;
                    break;
                }
            }
        
            if ($enCarrito) {

                // Si el producto ya está en el carrito, no se agregará a él, sino que redirigiremos a la página de productos:
                header('Location:'.url.'?controller=producto&action=productos');
                exit;
            
            } else {
                
                // Por el contrario, si el producto no estaba en el carrito, entonces si lo añadiremos:
                $producto_seleccionado = ProductoDAO::getProductoByID($producto_id);
                $pedido = new Pedido($producto_seleccionado);
                $_SESSION['productosSeleccionados'][] = serialize($pedido);
            }
        
            // Redirigimos a la página del carrito
            header('Location:'.url.'?controller=producto&action=productos');
            exit;
        }

        // Crearemos una función que determine que vista debemos mostrar al usuario, dependiendo si tiene productos seleccionados o no:
        public function carrito(){

            // Si la variable donde almacenamos los productos está vacía, redirigimos al usuario a una vista que le indique que no ha añadido ningún producto al carrito:
            if (empty($_SESSION['productosSeleccionados'])) {

                include_once 'vistas/header.php';      
                include_once 'vistas/panelCarritoVacio.php';
                include_once 'vistas/footer.php';

            } else {
        
                // Si la variable donde almacenamos los productos NO está vacía, mostraremos la vista que contiene el carrito con los productos:
                include_once 'vistas/header.php';
                include_once 'vistas/panelCarrito.php'; 
                include_once 'vistas/footer.php';
            }
        }
        
        // Crearemos una función para eliminar el producto del carrito:
        public function eliminarProducto() {

            // Recuperamos el ID del producto desde la URL:
            $posicionPedido = $_GET['id'];
        
            // Verificamos si el producto se encuentra dentro de la array de productos de la sesión:
            if (isset($_SESSION['productosSeleccionados'][$posicionPedido])) {

                // Eliminamos el producto seleccionado del carrito, la opción del coste de envío y el precio total del carrito:
                unset($_SESSION['productosSeleccionados'][$posicionPedido]);
                unset ($_SESSION['opcionLugarConsumir']);
                unset ($_SESSION['precioTotalCarrito']);
        
                // Reorganizamos las posiciones dentro de la array para que no queden posiciones vacías y nos de problemas:
                $_SESSION['productosSeleccionados'] = array_values($_SESSION['productosSeleccionados']);
        
                // Redirigiremos de nuevo a la página del carrito:
                header('Location:'.url.'?controller=producto&action=carrito');
                exit;

            } else {

                // En el caso de no encontrar el producto, redirigiremos a la página del carrito:
                header('Location:'.url.'?controller=producto&action=carrito');
                exit;
            }
        }

        // Crearemos una función para modificar la cantidad que deseamos comprar de un producto en concreto:
        public function modificarCantidad() {

            // Si el usuario pulsa el botón de añadir más cantidad, entonces:
            if (isset($_POST['sumarCantidad'])) {
        
                // Guardaremos el producto que vamos a modificar su cantidad:
                $posicionPedido = $_POST['sumarCantidad'];
        
                if (isset($_SESSION['productosSeleccionados'][$posicionPedido])) {
        
                    // Deserializamos el pedido:
                    $pedido = unserialize($_SESSION['productosSeleccionados'][$posicionPedido]);
        
                    // Verificamos si el objeto es válido;
                    if ($pedido instanceof Pedido) {
        
                        // Actualizamos la cantidad sumándole 1:
                        $pedido->setCantidad($pedido->getCantidad() + 1);
        
                        // Volvemos a serializar y lo guardamos en la sesión:
                        $_SESSION['productosSeleccionados'][$posicionPedido] = serialize($pedido);
                    }
                }
        
            // Si el usuario pulsa el botón de restar cantidad, entonces:
            } elseif (isset($_POST['restarCantidad'])) {
        
                // Guardaremos el producto que vamos a modificar su cantidad:
                $posicionPedido = $_POST['restarCantidad'];
        
                if (isset($_SESSION['productosSeleccionados'][$posicionPedido])) {
        
                    // Deserializamos el pedido
                    $pedido = unserialize($_SESSION['productosSeleccionados'][$posicionPedido]);
        
                    // Si la cantidad es 1, eliminamos el producto del carrito
                    if ($pedido->getCantidad() == 1) {
        
                        unset($_SESSION['productosSeleccionados'][$posicionPedido]);
        
                        // Verificamos si el carrito está vacío y redirigimos a la vista correspondiente:
                        if (empty($_SESSION['productosSeleccionados'])) {
        
                            header('Location:'.url.'?controller=producto&action=carrito');
                            exit();
                        }
        
                    } else {
        
                        // Actualizamos la cantidad restándole 1:
                        $pedido->setCantidad($pedido->getCantidad() - 1);
        
                        // Volvemos a serializar y guardamos en la sesión
                        $_SESSION['productosSeleccionados'][$posicionPedido] = serialize($pedido);
                    }
                }
            }
        
            // Recalculamos el precio total del pedido y el costo de envío:
            $precioTotal = calculadoraPrecios::precioTotalPedidoConEnvio($_SESSION['productosSeleccionados']);
            $costoEnvio = calculadoraPrecios::calcularCostoEnvio(calculadoraPrecios::obtenerOpcionComer());

            // Actualizamos el coste de envío y el precio total en la sesión:
            $_SESSION['precioTotalCarrito'] = $precioTotal + $costoEnvio;
            $_SESSION['costoEnvio'] = $costoEnvio;
            
            // Redirigiremos al usuario a la página del carrito:
            header('Location:'.url.'?controller=producto&action=carrito');
            exit();
        }  
        
        // Crearemos una función para averiguar donde quiere consumir el cliente su pedido:
        public function lugarConsumo() {
            
            // Nos aseguramos de que la variable de sesión que guarda los productos seleccionados está definido y es un array:
            $productosSeleccionados = isset($_SESSION['productosSeleccionados']) && is_array($_SESSION['productosSeleccionados']) ? $_SESSION['productosSeleccionados'] : [];
        
            // Guardaremos en una variable el precio total antes de redirigir
            $precioTotal = calculadoraPrecios::precioTotalPedidoConEnvio($productosSeleccionados);
        
            // Guardaremos en una variable el resultado de la llamada a la función que nos muestra qué opción ha escogido el usuario.
            $opcionSeleccionada = calculadoraPrecios::obtenerOpcionComer();
        
            // Guardaremos la opción seleccionada y el precio total en variables de sesión
            $_SESSION['opcionLugarConsumir'] = $opcionSeleccionada;
            $_SESSION['precioTotalCarrito'] = $precioTotal;
        
            // Redirige a la página del carrito
            header('Location:'.url.('?controller=producto&action=carrito'));
            exit();
        }
    }
?>