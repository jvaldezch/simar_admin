<?php

class Application_Model_Table_Repositorio {

    protected $id;
    protected $idCliente;
    protected $directorio;
    protected $archivo;
    protected $creado;

    public function __set($name, $value) {
        $method = "set" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid property");
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid property");
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = "set" . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    function getId() {
        return $this->id;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function getCreado() {
        return $this->creado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function setCreado($creado) {
        $this->creado = $creado;
    }

    function getDirectorio() {
        return $this->directorio;
    }

    function setDirectorio($directorio) {
        $this->directorio = $directorio;
    }

}
