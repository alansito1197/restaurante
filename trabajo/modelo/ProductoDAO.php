<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Producto.php';
    include_once 'modelo/Pizza.php';

    class ProductoDAO {

        // Crearemos una función que nos recoja todos los datos de todos los productos de la base de datos:
        public static function getAllProducts() {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Crearemos una consulta para mostrar todos los productos que no sean pizzas:
            $stmt = $conexion->query("SELECT id_producto, id_administrador, id_categoria_producto, nombre, sabor, valor_energetico, precio, disponibilidad, stock, imagen, ingredientes, valoracion, producto_destacado FROM producto WHERE tipo_masa IS NULL");

            // Creamos una variable definiéndola como array para después agregar los productos en ella:
            $productos = [];

            // Utilizaremos un bucle para agregar cada objeto de tipo producto a esta array:
            while ($objeto = $stmt->fetch_object('Producto')) {
                $productos[] = $objeto;
            }

            // Crearemos una consulta para mostrar todos los productos que sean pizzas:
            $stmt = $conexion->query("SELECT * FROM PRODUCTO WHERE tipo_masa IS NOT NULL");

            // Utilizaremos un bucle para agregar cada objeto de tipo producto a esta array:
            while ($objeto = $stmt->fetch_object('Pizza')) {
                $productos[] = $objeto;
            }

            // Devolvemos el resultado de la operación:
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

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Crearemos una variable para guardar solamente los productos que tenemos indicados como destacados:
            $productoDestacado = $conexion->query("SELECT * FROM PRODUCTO WHERE producto_destacado='Si'");

            // Creamos una variable definiéndola como array para después agregar los productos en ella:
            $productos_destacados = [];

            // Utilizaremos un bucle para agregar cada objeto de tipo producto a esta array:
            while ($obj = $productoDestacado->fetch_object('Producto')) {
                $productos_destacados[] = $obj;
            }

            // Devolveremos 
            return $productos_destacados;
        }

        // Crearemos una función para obtener el producto en cuestión mediante su ID:
        public static function getProductoByID($id_producto) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
            
            // Preparamos la consulta para obtener el producto por ID:
            $stmt = $conexion->prepare("SELECT * FROM PRODUCTO WHERE id_producto=?");

            // Vinculamos los parámetros:
            $stmt->bind_param("i", $id_producto);
        
            // Ejecutamos la consulta:
            $stmt->execute();

            // Guardamos el resultado en una variable:
            $resultado = $stmt->get_result();

            // Cerramos la conexión a la base de datos:
            $conexion->close();
        
            // Almacenamos el resultado en una lista:
            $añadirCarrito = $resultado->fetch_object('Producto');

            // Devolveremos cada
            return $añadirCarrito;
        }

        // Crearemos una función para obtener los datos del producto que estemos mostrando en una vista:
        public static function obtenerProductoByID($id_producto) {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Preparamos la consulta para obtener el producto por ID:
            $stmt = $conexion->prepare("SELECT * FROM PRODUCTO WHERE id_producto=?");

            // Vinculamos los parámetros:
            $stmt->bind_param("i", $id_producto);
        
            // Ejecutamos la consulta:
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            // Obtenemos el objeto Producto utilizando fetch_object:
            $producto = $resultado->fetch_object('Producto');
        
            // Cerramos la conexión a la base de datos:
            $conexion->close();
            
            // Devolvemos el objeto Producto:
            return $producto;
        }
        
        // Crearemos una función para agregar un producto en nuestra base de datos:
        public function agregarProducto($usuario_id, $categoriaProducto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado, $imagen, $valoracion) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Crearemos una consulta para agregar los parámetros enviados a este método en el producto que estamos agregando a la base de datos:
            $agregarProducto = "INSERT INTO PRODUCTO (id_administrador, id_categoria_producto, nombre, sabor, valor_energetico, precio, disponibilidad, stock, ingredientes, producto_destacado, imagen, valoracion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = $conexion->prepare($agregarProducto);
        
            $stmt->bind_param("iisssdssssss", $usuario_id, $categoriaProducto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado, $imagen, $valoracion);
        
            // Ejecutamos la consulta:
            $stmt->execute();
        
            // Guardamos el resultado en una variable:
            $resultado = $stmt->get_result();

            // Cerramos la conexión a la base de datos y la consulta:
            $stmt->close();
            $conexion->close();
        
            // Devolveremos el resultado de la inserción del producto:
            return $resultado;
        }
        
        // Crearemos una función para modificar un producto existente en nuestra base de datos:
        public static function actualizarProducto($idProducto, $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $ingredientes, $producto_destacado) {
            
            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Creamos una consulta para actualizar los datos del producto:
            $producto = "UPDATE PRODUCTO SET nombre = ?, sabor = ?, valor_energetico = ?, precio = ?, disponibilidad = ?, stock = ?, ingredientes = ?, producto_destacado = ? WHERE id_producto=?";

            // Preparamos la consulta:
            $stmt = $conexion->prepare($producto);

            // Vinculamos los parámetros:
            $stmt->bind_param("ssidsissi", $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $ingredientes, $producto_destacado, $idProducto);
            
            // Ejecutamos la consulta
            $stmt->execute();

            // Guardamos el resultado en una variable:
            $resultado = $stmt->get_result();
        
            // Cerramos la conexión a la base de datos y la consulta:
            $stmt->close();
            $conexion->close();
            
            // Devolvemos el resultado de la actualización producto:
            return $resultado;
        }
        
        // Crearemos una función para eliminar un producto en concreto de nuestra base de datos:
        public static function eliminarProducto($id_producto){

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();
        
            // Preparamos la consulta para eliminar el producto por ID:
            $stmt = $conexion->prepare("DELETE FROM PRODUCTO WHERE id_producto=?");

            // Vinculamos los parámetros:
            $stmt->bind_param("i", $id_producto);
            
            // Ejecutamos la consulta:
            $stmt->execute();
            
            // Cerramos la conexión a la base de datos y la consulta:
            $conexion->close();
            $stmt->close();
        }
    }
?>