<?php

class Application_Model_Table_Actividad {

    protected $id;
    protected $idSello;
    protected $edocument;
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

    function getIdSello() {
        return $this->idSello;
    }

    function getEdocument() {
        return $this->edocument;
    }

    function getCreado() {
        return $this->creado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdSello($idSello) {
        $this->idSello = $idSello;
    }

    function setEdocument($edocument) {
        $this->edocument = $edocument;
    }

    function setCreado($creado) {
        $this->creado = $creado;
    }

}
