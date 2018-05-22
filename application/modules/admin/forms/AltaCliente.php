<?php

class Administrador_Form_AltaCliente extends Zend_Form {

    public function init() {
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
        $this->setIsArray(true);

        $this->addElement("text", "rfc", array(
            "label" => "RFC:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "razonSocial", array(
            "label" => "RAZÓN SOCIAL:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "2"),
            "class" => "form-control input-sm",
        ));
    }

}
