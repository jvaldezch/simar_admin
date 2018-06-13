<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        $this->setName("login");
        
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('class' => 'sr-only')),
            array('HtmlTag', array('tag' => 'span', 'placement' => 'APPEND')),
        ));

        $this->addElement('text', 'username', array(
            'filters' => array('StringTrim', 'StringToLower', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'placeholder' => "Usuario",
            'required' => true,
            'label' => 'Usuario:',
            //'title' => 'Proporcionar usuario',
            'attribs' => array('class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus', 'autocomplete' => 'off'),
        ));

        $this->addElement('password', 'password', array(
            'filters' => array('StringTrim', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'placeholder' => "Contraseña",
            'required' => true,
            'label' => 'Contraseña:',
            //'title' => 'Proporcionar contraseña de acceso',
            'attribs' => array('class' => 'form-control', 'required' => 'required'),
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore' => true,
            'label' => 'Acceder',
            'attribs' => array('id' => 'submit'),
        ));
        
    }

}
