<?php

class Application_Form_Producto extends Zend_Form {

    protected $name;

    function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    public function init() {
        $this->setAction("/usuarios/ajax/guardar-producto");
        $this->setName($this->getName());
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('class' => 'control-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
        ));

        $unitso = new Usuarios_Model_OmaMapper();
        $oma[''] = '---';
        foreach ($unitso->fetchAll() as $item) {
            $oma[$item["oma"]] = $item["oma"];
        }

        $this->addElement('hidden', 'id', array(
            'decorators' => array('ViewHelper', 'HtmlTag')
        ));

        $this->addElement('hidden', 'idFactura', array(
            'decorators' => array('ViewHelper', 'HtmlTag')
        ));

        $this->addElement('text', 'fraccion', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 25)),
            ),
            'required' => true,
            'label' => 'Fracción:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'subFraccion', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 25)),
            ),
            'required' => true,
            'label' => 'Subfracción:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'numParte', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 150)),
            ),
            'required' => true,
            'label' => 'Num. parte:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'descripcion', array(
            'filters' => array('StringTrim', 'StringToUpper', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Descripción:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'precioUnitario', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Precio Unitario:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'valorComercial', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Valor Comercial:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'valorDolares', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Valor Dolares:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'valorMxn', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Valor MXN:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'cantidadFactura', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Cantidad Factura:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'cantidadOma', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'Cantidad OMA:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('select', 'oma', array(
            'filters' => array('StringTrim', 'StripTags'),
            'required' => true,
            'label' => 'OMA:',
            'class' => 'form-control input-sm',
            'multioptions' => $oma,
        ));

        $this->addElement('text', 'marca', array(
            'filters' => array('StringTrim', 'StripTags'),
            'label' => 'Marca:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'modelo', array(
            'filters' => array('StringTrim', 'StripTags'),
            'label' => 'Modelo:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'submodelo', array(
            'filters' => array('StringTrim', 'StripTags'),
            'label' => 'Submodelo:',
            'class' => 'form-control input-sm',
        ));

        $this->addElement('text', 'numSerie', array(
            'filters' => array('StringTrim', 'StripTags'),
            'label' => 'Num. Serie:',
            'class' => 'form-control input-sm',
        ));
    }

}
