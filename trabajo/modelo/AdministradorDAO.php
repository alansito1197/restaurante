<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Administrador.php';

    class AdministradorDAO {

        // Crearemos una función para conectarnos a nuestra base de datos:
        public static function conectarBaseDeDatos() {
            $db = new DataBase();
            return $db->connect();
        }

        public static function obtenerPasswordAdmin($usuario_id) {
            
            // Crearemos una consulta a la base de datos para buscar la contraseña del usuario:
            $password_bbdd = "SELECT credencial.password FROM credencial WHERE credencial.id_administrador = '$usuario_id'";

            // Ejecutaremos la consulta mediante la llamada al método que se conecta a la base de datos:
            $ejecutar_busqueda = self::conectarBaseDeDatos()->query($password_bbdd);

            if ($ejecutar_busqueda->num_rows > 0) {

                // Si encontramos algún registro relacionado, guardamos la fila relacionada a la contraseña:
                $fila = $ejecutar_busqueda->fetch_assoc();
                return $fila['password'];

            } else {

                // Si no encontramos ningún registro, devolveremos nulo:
                return null;
            }
        }

        public function agregarProducto($id_administrador, $categoria_producto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado, $imagen, $valoracion) {
            
            try {

                $conexion = self::conectarBaseDeDatos();
        
                $sql = "INSERT INTO PRODUCTO (id_administrador, id_categoria_producto, nombre, sabor, valor_energetico, precio, disponibilidad, stock, ingredientes, producto_destacado, imagen, valoracion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("iisssdssssss", $id_administrador, $categoria_producto, $nombre, $sabor, $calorias, $precio, $disponibilidad, $stock, $ingredientes, $destacado, $imagen, $valoracion);
        
                $resultado = $stmt->execute();
        
                if (!$resultado) {
                    throw new Exception("Error en la consulta: " . mysqli_error($conexion));
                }
        
                $stmt->close();
                $conexion->close();
        
                return $resultado;

            } catch (Exception $e) {
                // Manejo de excepciones
                throw $e;
            }
        }

        public function obtenerTodosLosProductos() {

            $conexion = self::conectarBaseDeDatos();
            $sql = "SELECT * FROM PRODUCTO";
            $resultado = $conexion->query($sql);
    
            $productos = array();
    
            while ($fila = $resultado->fetch_assoc()) {
                $productos[] = $fila;
            }

            // Almacena los productos en una variable de sesión
            $_SESSION['productos'] = $productos;
    
            $conexion->close();
    
            return $productos;
        }

        public static function obtenerProductoPorId($idProducto) {

            $conexion = self::conectarBaseDeDatos();
            $producto = "SELECT * FROM PRODUCTO WHERE id_producto = ?";
            // Preparamos la consulta:
            $consulta = $conexion->prepare($producto);
    
            // Vincularemos el parámetro de la anterior consulta al valor del ID indicado:
            $consulta->bind_param("i", $idProducto);
    
            // Ejecutaremos la consulta:
            $consulta->execute();
            
            // Obtendremos el resultado de la ejecución de la consulta y la guardaremos en una variable:
            $result = $consulta->get_result();
                
            // Asignamos el resultado a la variable datos:
            $datos = $result->fetch_assoc();
            
            // Cerramos la consulta preparada y la conexión a la base de datos:
            $consulta->close();
            $conexion->close();
            
            // Finalmente, devolvemos la información del usuario:
            return $datos;
        }
        
        public static function actualizarProducto($idProducto, $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $imagen, $ingredientes, $producto_destacado) {
            $conexion = self::conectarBaseDeDatos();
            
            // La consulta UPDATE para actualizar el producto
            $producto = "UPDATE PRODUCTO SET nombre=?, sabor=?, valor_energetico=?, precio=?, disponibilidad=?, stock=?, imagen=?, ingredientes=?, producto_destacado=? WHERE id_producto=?";
            
            // Preparamos la consulta
            $consulta = $conexion->prepare($producto);
            
            // Vinculamos los parámetros
            $consulta->bind_param("ssiiisisii", $nombre, $sabor, $valor_energetico, $precio, $disponibilidad, $stock, $imagen, $ingredientes, $producto_destacado, $idProducto);
            
            // Ejecutamos la consulta
            $resultado = $consulta->execute();
            
            // Verificamos si la consulta fue exitosa
            if ($resultado) {
                // Cerramos la conexión
                $consulta->close();
                $conexion->close();
                return true; // Devolvemos true si la actualización fue exitosa
            } else {
                // En caso de error
                $consulta->close();
                $conexion->close();
                return false; // Devolvemos false si la actualización falló
            }
        }
        

        public function eliminarProductoSeleccionado(){

        }


    }
        
?>