<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/Categoria.php';

    class CategoriaDAO {

        public static function getAllCategorias() {
            $conexion = DataBase::connect();
            $stmt = $conexion->query("SELECT * FROM categoria_producto");

            $categorias = [];

            while ($obj = $stmt->fetch_object('Categoria')) {
                $categorias[] = $obj;
            }

            return $categorias;
        }

    }
?>
