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

                public function setProducto($producto): self{
                        $this->producto = $producto;
                        return $this;
                }
                public function getIdPedido(){
                        return $this->id_pedido;
                }

                public function setIdPedido($id_pedido): self{
                        $this->id_pedido = $id_pedido;
                        return $this;
                }

                public function getCantidad(){
                        return $this->cantidad;
                }

                public function setCantidad($cantidad): self{
                        $this->cantidad = $cantidad;
                        return $this;
                }

                public function getOpciones(){
                        return $this->opciones;
                }

                public function setOpciones($opciones): self{
                        $this->opciones = $opciones;
                        return $this;
                }

                public function agregarOpcion($opcion){
                        $this->opciones[] = $opcion;
                }
        }
?>