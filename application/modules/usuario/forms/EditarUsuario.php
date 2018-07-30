<?php

class Administrador_Form_EditarUsuario extends Zend_Form {

    public function init() {
        $this->setAction("/administrador/ajax/editar-usuario");
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

        $this->addElement("hidden", "id", array(
            "decorators" => array("ViewHelper", "HtmlTag")
        ));

        $this->addElement("text", "username", array(
            "label" => "USUARIO:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm",
            "required" => true,
        ));

        $this->addElement("text", "nombre", array(
            "label" => "NOMBRE:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "2"),
            "class" => "form-control input-sm",
            "required" => true,
        ));

        $this->addElement("text", "email", array(
            "label" => "EMAIL:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "2"),
            "class" => "form-control input-sm",
            "required" => true,
        ));

        $this->addElement("password", "password", array(
            "label" => "CONTRASEÑA:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "3"),
            "class" => "form-control input-sm",
            "required" => true,
        ));

        $this->addElement("password", "repeat", array(
            "label" => "REPETIR CONTRASEÑA:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "4"),
            "class" => "form-control input-sm",
            "required" => true,
        ));
    }

}
