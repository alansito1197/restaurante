<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Categoria.php';

    class CategoriaDAO {

        // Crearemos una función para mostrar toda la información de cada categoría en la página principal:
        public static function getAllCategorias() {

            // Nos conectamos a la base de datos:
            $conexion = DataBase::connect();

            // Creamos una consulta para recoger todos los datos que nos interesa:
            $stmt = $conexion->query("SELECT * FROM categoria_producto");

            // Definimos una variable de tipo array para guardar dentro de ella las categorías:
            $categorias = [];

            // Utilizaremos un bucle para guardar cada objeto obtenido en la variable que hemos definido anteriormente:
            while ($objeto = $stmt->fetch_object('Categoria')) {
                $categorias[] = $objeto;
            }

            // Devolveremos el valor de la variable:
            return $categorias;
        }
    }
?>
