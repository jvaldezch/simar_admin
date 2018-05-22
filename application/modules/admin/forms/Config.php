<?php

class Administrador_Form_Config extends Zend_Form {

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

        $this->addElement("text", "email", array(
            "label" => "Email (para respuestas VUCEM):",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "template", array(
            "label" => "Plantilla ejemplo (Debe existir en directorio 'library'):",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
        ));
    }

}
