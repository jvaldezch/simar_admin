<?php

class Application_Form_DatosGenerales extends Zend_Form {

    protected $idCliente;
    protected $idProveedor;
    protected $edit;

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdProveedor() {
        return $this->idProveedor;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    function getEdit() {
        return $this->edit;
    }

    function setEdit($edit) {
        $this->edit = $edit;
    }

    public function init() {
        $this->setMethod('post');
        $this->setName($this->getName());
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('class' => 'control-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
        ));
        
        $mapper = new Usuarios_Model_ClientesSelloAgente();
        $patentes = $mapper->agentesOptions($this->idCliente);

        $ids = new Application_Model_IdentificadoresMapper();
        $identificadores[''] = "---";
        foreach ($ids->fetchAll() as $item) {
            $identificadores[$item["id"]] = $item["descripcion"];
        }

        if (isset($this->idCliente) && !isset($this->idProveedor)) {
            $mapper = new Usuarios_Model_ClientesMapper();
        } elseif (isset($this->idCliente) && isset($this->idProveedor)) {
            $mapper = new Usuarios_Model_ProveedoresMapper();
        }
        $nombres[''] = "---";
        foreach ($mapper->fetchAll() as $item) {
            $nombres[$item["id"]] = $item["razonSocial"];
        }

        if (isset($this->idCliente) && !isset($this->idProveedor)) {
            $array = $mapper->fetchRowForm($this->idCliente);
        } elseif (isset($this->idCliente) && isset($this->idProveedor)) {
            $array = $mapper->fetchRowForm($this->idProveedor, $this->idCliente);
        }

        $patente = new Zend_Form_Element_Select(array(
            'name' => 'patente',
            'required' => true,
            'label' => 'Patente:',
            'multioptions' => $patentes,
            'class' => 'form-control input-sm',
        ));
        if (isset($array["patente"])) {
            $patente->setValue($array["patente"]);
        }
        
        $idIdentificador = new Zend_Form_Element_Select(array(
            'name' => 'idIdentificador',
            'required' => true,
            'label' => 'Id:',
            'multioptions' => $identificadores,
            'class' => 'form-control input-sm',
        ));
        if (isset($array["idIdentificador"])) {
            $idIdentificador->setValue($array["idIdentificador"]);
        }

        $cliente = new Zend_Form_Element_Select(array(
            'name' => 'nombre',
            'required' => true,
            'label' => 'Nombre:',
            'multioptions' => $nombres,
            'class' => 'form-control input-sm',
        ));
        
        if (isset($array["idCliente"])) {
            $cliente->setValue($array["idCliente"]);
        }

        $identificador = new Zend_Form_Element_Text(array(
            'name' => 'identificador',
            'required' => true,
            'label' => 'Identificador:',
            'class' => 'form-control input-sm',
        ));
        if (isset($array["identificador"])) {
            $identificador->setValue($array["identificador"]);
        }

        if (isset($this->edit) && $this->edit === false) {
            $idIdentificador->setAttrib("readonly", "true");
            $identificador->setAttrib("readonly", "true");
        }
        
        $this->addElement($patente);
        $this->addElement($cliente);
        $this->addElement($idIdentificador);
        $this->addElement($identificador);

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }

}
