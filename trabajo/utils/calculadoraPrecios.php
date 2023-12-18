<?php
    class calculadoraPrecios{

        // Función que utilizamos para que nos actualice el precio del producto cuando modificamos su cantidad:
        public static function precioProductoIndividual($pedido) {
            
            if ($pedido instanceof Pedido) {

                return $pedido->getProducto()->getPrecio() * $pedido->getCantidad();
            }
    
            return 0;
        }

        // Esta función suma los precios individuales de todos los productos en el carrito, calculados con la función anterior. 
        // Proporciona el subtotal del carrito:

        public static function precioSubtotalPedido($pedidos){
            
            $precioSubtotal = 0;

            foreach ($pedidos as $pedidoSerialized) {

                $pedido = unserialize($pedidoSerialized);

                if ($pedido instanceof Pedido) {
                
                    $precioSubtotal += $pedido->getProducto()->getPrecio() * $pedido->getCantidad();
                }
            }

            return $precioSubtotal;
        }

        // Crearemos una función para obtener la opción de dónde desea consumir el pedido el cliente:
        public static function obtenerOpcionComer() {

            if (isset($_POST['seleccionarDondeConsumir'], $_POST['opcionComer'])) {

                return $_POST['opcionComer'];
            }
        
            return "Por definir";
        }

        // Crearemos una función para calcular el coste de envío según la opción seleccionada previamente:
        public static function calcularCostoEnvio($opcionLugarConsumir) {
            switch ($opcionLugarConsumir) {
                case 'Gratis':
                    return 0;
                case '0,25€':
                    return 0.25;
                case '5,25€':
                    return 5.25;
                default:
                    return 0;
            }
        }
        
        // Crearemos una función para obtener el precio total del pedido incluyendo el coste de envío.
        public static function precioTotalPedidoConEnvio($pedidos) {
            
            // Obtenemos el precio del subtotal llamándo a la función que se encarga de calcularlo:
            $subtotal = self::precioSubtotalPedido($pedidos);

            // Obtenemos el coste de envio llamándo a la función que se encarga de calcularlo:
            $costeEnvio = self::calcularCostoEnvio(self::obtenerOpcionComer());

            // Guardamos la suma del valor del subtotal y del coste del envío en una variable:
            $precioTotal = $subtotal + $costeEnvio;

            // Guardamos en una variable de sesión esta última variable creada:
            $_SESSION['precioTotalCarrito'] = $precioTotal;

            return $precioTotal;
        }
    }
?>