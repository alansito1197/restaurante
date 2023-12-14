<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Producto.php';
    include_once 'modelo/Pizza.php';

    class ProductoDAO {

        // Crearemos una función para conectarnos a nuestra base de datos:
        public static function conectarBaseDeDatos() {
            $db = new DataBase();
            return $db->connect();
        }

        // Crearemos una función que nos recoja todos los datos de todos los productos de la base de datos:
        public static function getAllProducts() {
            $conexion = self::conectarBaseDeDatos();
            $stmt = $conexion->query("SELECT id_producto, id_administrador, id_categoria_producto, nombre, sabor, valor_energetico, precio, disponibilidad, stock, imagen, ingredientes, valoracion, producto_destacado FROM producto WHERE tipo_masa IS NULL");

            $productos = [];

            while ($obj = $stmt->fetch_object('Producto')) {
                $productos[] = $obj;
            }

            $stmt = $conexion->query("SELECT * FROM producto WHERE tipo_masa IS NOT NULL");


            while ($obj = $stmt->fetch_object('Pizza')) {
                $productos[] = $obj;
            }

            return $productos;
        }

        // Creamos una función para saber qué código CSS debemos aplicarle al valor de Disponibilidad de cada producto:
        public static function getDisponibilidad($disponibilidad) {
            $color_disponibilidad = "";
            switch ($disponibilidad) {
                case "Disponible online":
                    return $color_disponibilidad = "disponible_online";
                case "No disponible":
                    return $color_disponibilidad = "no_disponible";
                case "Proximamente":
                    return $color_disponibilidad = "proximamente";
            }
        }

        // Creamos una función para mostrar los productos que sean destacados en la página principal de la web:
        public static function getAllProductosDestacados() {

            $conexion = self::conectarBaseDeDatos();
            $stmt = $conexion->query("SELECT * FROM producto WHERE producto_destacado='1'");

            $productos_destacados = [];

            while ($obj = $stmt->fetch_object('Producto')) {
                $productos_destacados[] = $obj;
            }

            return $productos_destacados;
        }

        // Crearemos una función para obtener el producto en cuestión mediante su ID:
        public static function getProductoByID($id_producto) {
            
            $conexion = self::conectarBaseDeDatos();
            
            // Preparamos la consulta para obtener el producto por ID:
            $stmt = $conexion->prepare("SELECT * FROM producto WHERE id_producto=?");
            $stmt->bind_param("i", $id_producto);
        
            // Ejecutamos la consulta:
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Cerramos la conexión a la base de datos:
            $conexion->close();
        
            // Almacenamos el resultado en una lista:
            $añadir_carrito = $resultado->fetch_object('Producto');
            return $añadir_carrito;
        }
        
        public function obtenerTodosLosProductos() {

            try {
                $conexion = self::conectarBaseDeDatos();
    
                $sql = "SELECT * FROM PRODUCTO";
                $resultado = $conexion->query($sql);
    
                $productos = array();
    
                while ($fila = $resultado->fetch_assoc()) {
                    $productos[] = $fila;
                }
    
                $conexion->close();
    
                return $productos;
            } catch (Exception $e) {
                
                throw $e;
            }
        }
    }
?>