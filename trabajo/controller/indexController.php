<?php

    include_once 'config/dataBase.php';

    class indexController{

        public function index(){
            
            // Llamaremos a las funciones necesarias para mostrar los productos que deseamos en la página principal:
            $AllCategorias = CategoriaDAO::getAllCategorias();
            $AllProductosDestacados = ProductoDAO::getAllProductosDestacados();

            // Incluiremos las vistas necesarias:
            include_once 'vistas/header.php';
            include_once 'vistas/panelPrincipal.php'; 
            include_once 'vistas/footer.php';
        }
    }
?>