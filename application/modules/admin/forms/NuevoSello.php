<?php

class Administrador_Form_NuevoSello extends Zend_Form {

    public function init() {
        $this->setAction("/administrador/ajax/cargar-sello");
        $this->clearDecorators();
        $this->addDecorator("FormElements")
                ->addDecorator("Form");

        $this->setElementDecorators(array(
            array("ViewHelper"),
            array("Errors"),
            array("Description"),
            array("Label", array("class" => "control-label")),
            array("HtmlTag", array("tag" => "div", "class" => "form-group")),
        ));

        $this->addElement("hidden", "idCliente", array(
            "decorators" => array("ViewHelper", "HtmlTag")
        ));
        $this->addElement("hidden", "idAgente", array(
            "decorators" => array("ViewHelper", "HtmlTag")
        ));

        $this->addElement("password", "password", array(
            "label" => "CONTRASEÑA:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
            "required" => true,
        ));

        $this->addElement("password", "webservice", array(
            "label" => "CONTRASEÑA WEB SERVICE:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
            "required" => true,
        ));
    }

}
