<?php

class Application_Form_ClienteProveedor extends Zend_Form {

    protected $name;
    protected $customer;

    function setName($name) {
        $this->name = $name;
    }
    
    function setCustomer($customer) {
        $this->customer = $customer;
    }

    function getName() {
        return $this->name;
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
        foreach ($ids->fetchAll() as $item) {
            $data[$item["id"]] = $item["descripcion"];
        }
        
        $this->addElement('hidden', 'idCliente', array(
            'decorators' => array('ViewHelper', 'HtmlTag')
        ));
        
        $this->addElement('hidden', 'idProveedor', array(
            'decorators' => array('ViewHelper', 'HtmlTag')
        ));        

        $this->addElement('select', 'idIdentificador', array(
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Id:',
            'multioptions' => $data,
            'class' => 'form-control input-sm',
            'attribs' => array("disabled" => "disabled"),
        ));

        $this->addElement('text', 'razonSocial', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Nombre:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'identificador', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Identificador:',
            'class' => 'form-control input-sm',
        ));
        
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
        
    }

}
