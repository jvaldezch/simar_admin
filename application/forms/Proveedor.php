<?php

class Application_Form_Proveedor extends Zend_Form {

    protected $idCliente;
    protected $edit;

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
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

        $ids = new Application_Model_IdentificadoresMapper();
        $identificadores[''] = "---";
        foreach ($ids->fetchAll() as $item) {
            $identificadores[$item["id"]] = $item["descripcion"];
        }
        
        $mapper = new Usuarios_Model_ProveedoresMapper();        
        $nombres[''] = "---";
        foreach ($mapper->fetchAll() as $item) {
            $nombres[$item["id"]] = $item["razonSocial"];
        }
        
        $decorators = array('ViewHelper','HtmlTag', 'Label');

        $idIdentificador = new Zend_Form_Element_Select(array(
            'name' => 'idIdentificador',
            'required' => true,
            'label' => 'Id:',
            'multioptions' => $identificadores,
            'class' => 'form-control input-sm',
            'decorators' => $decorators
        ));
        $this->addElement($idIdentificador);

        $cliente = new Zend_Form_Element_Select(array(
            'name' => 'idProveedor',
            'required' => true,
            'label' => 'Nombre:',
            'multioptions' => $nombres,
            'class' => 'form-control input-sm',
            'decorators' => $decorators
        ));
        $this->addElement($cliente);

        $identificador = new Zend_Form_Element_Text(array(
            'name' => 'identificador',
            'required' => true,
            'label' => 'Identificador:',
            'class' => 'form-control input-sm',
            'decorators' => $decorators
        ));
        $this->addElement($identificador);

        if (isset($this->edit) && $this->edit === false) {
            $idIdentificador->setAttrib("readonly", "true");
            $cliente->setAttrib("readonly", "true");
            $identificador->setAttrib("readonly", "true");
        }

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }

}
