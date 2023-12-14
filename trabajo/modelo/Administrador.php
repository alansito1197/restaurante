<?php
    class Administrador {
        
                protected $id_administrador;
                protected $nombre;
                protected $apellidos;
                protected $email;
                protected $salario;
                
                public function __construct (){
                        
                }

                public function getIdCliente(){
                        return $this->id_administrador;
                }

                public function setIdCliente($id_administrador): self{
                        $this->id_administrador = $id_administrador;
                        return $this;
                }

                public function getNombre(){
                        return $this->nombre;
                }

                public function setNombre($nombre): self{
                        $this->nombre = $nombre;
                        return $this;
                }

                public function getApellidos(){
                        return $this->apellidos;
                }

                public function setApellidos($apellidos): self{
                        $this->apellidos = $apellidos;
                        return $this;
                }

                public function getEmail(){
                        return $this->email;
                }

                public function setEmail($email): self{
                        $this->email = $email;
                        return $this;
                }

                public function getSalario(){
                        return $this->salario;
                }

                public function setSalario($salario): self{
                        $this->salario = $salario;
                        return $this;
                }


        }
?>