<?php

        class Pedidos {

                protected $id_pedido;
                protected $id_cliente;
                protected $tipo_usuario;
                protected $precio_total;
                protected $fecha;
                protected $estado;

                public function __construct(){

                }

                public function getIdPedido(){
                        return $this->id_pedido;
                }

                public function setIdPedido($id_pedido): self{
                        $this->id_pedido = $id_pedido;
                        return $this;
                }

                public function getIdCliente(){
                        return $this->id_cliente;
                }

                public function setIdCliente($id_cliente): self{
                        $this->id_cliente = $id_cliente;
                        return $this;
                }
                public function getTipoUsuario(){
                        return $this->tipo_usuario;
                }

                public function setTipoUsuario($tipo_usuario): self{
                        $this->tipo_usuario = $tipo_usuario;
                        return $this;
                }
                public function getPrecioTotal(){
                        return $this->precio_total;
                }

                public function setPrecioTotal($precio_total): self{
                        $this->precio_total = $precio_total;
                        return $this;
                }
                public function getFecha(){
                        return $this->fecha;
                }

                public function setFecha($fecha): self{
                        $this->fecha = $fecha;
                        return $this;
                }
                public function getEstado(){
                        return $this->estado;
                }

                public function setEstado($estado): self{
                        $this->estado = $estado;
                        return $this;
                }
                
        }
?>