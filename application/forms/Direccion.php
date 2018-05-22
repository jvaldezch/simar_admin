<?php

class Application_Form_Direccion extends Zend_Form {

    protected $name;

    function setName($name) {
        $this->name = $name;
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
        
        $countries = new Usuarios_Model_PaisesMapper();
        $paises[''] = "---";
        foreach ($countries->fetchAll() as $item) {
            $paises[$item["clavePais"]] = $item["clavePais"] . ' - ' . $item["nombre"];
        }

        $this->addElement('text', 'calle', array(
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Calle:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'numExterior', array(
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Num. Exterior:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'numInterior', array(
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Num. Interior:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'colonia', array(
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Colonia:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'localidad', array(
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Localidad:',
            'class' => 'form-control input-sm',
        ));
        
        $this->addElement('text', 'codigoPostal', array(
            'validators' => array(
                array('StringLength', false, array(0, 15)),
            ),
            'required' => true,
            'label' => 'Código Postal:',
            'class' => 'form-control input-sm',
        ));
        
        $this->addElement('text', 'estado', array(
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Estado:',
            'class' => 'form-control input-sm',
        ));
        
        $this->addElement('select', 'pais', array(
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'País:',
            'class' => 'form-control input-sm',
            'multioptions' => $paises,
        ));
    }

}
