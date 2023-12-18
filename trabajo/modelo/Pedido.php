<?php

        class Pedido {

                protected $producto;
                protected $id_pedido;
                protected $cantidad = 1;
                protected $opciones = [];

                public function __construct($producto){
                        $this->producto = $producto;
                }

                public function getProducto(){
                        return $this->producto;
                }

                public function setProducto($producto){
                        $this->producto = $producto;
                        return $this;
                }
                public function getIdPedido(){
                        return $this->id_pedido;
                }

                public function setIdPedido($id_pedido){
                        $this->id_pedido = $id_pedido;
                        return $this;
                }

                public function getCantidad(){
                        return $this->cantidad;
                }

                public function setCantidad($cantidad){
                        $this->cantidad = $cantidad;
                        return $this;
                }

                public function getOpciones(){
                        return $this->opciones;
                }

                public function setOpciones($opciones){
                        $this->opciones = $opciones;
                        return $this;
                }

                public function agregarOpcion($opcion){
                        $this->opciones[] = $opcion;
                }
        }
?>