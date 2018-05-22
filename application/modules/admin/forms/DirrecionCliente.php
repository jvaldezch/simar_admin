<?php

class Administrador_Form_DirrecionCliente extends Zend_Form {

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

        $this->addElement("hidden", "idCliente", array());

        $this->addElement("text", "rfc", array(
            "label" => "RFC:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1", "disabled" => "true"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "razonSocial", array(
            "label" => "RAZÓN SOCIAL:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "2", "disabled" => "true"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "calle", array(
            "label" => "CALLE:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "3"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "numExterior", array(
            "label" => "NUM. EXTERIOR:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "4"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "numInterior", array(
            "label" => "NUM. INTERIOR:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "5"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "colonia", array(
            "label" => "COLONIA:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "6"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "localidad", array(
            "label" => "LOCALIDAD:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "7"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "municipio", array(
            "label" => "MUNICIPIO:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "8"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "estado", array(
            "label" => "ESTADO:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "9"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "cp", array(
            "label" => "CODIGO POSTAL:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "10"),
            "class" => "form-control input-sm",
        ));

        $this->addElement("text", "pais", array(
            "label" => "PAÍS:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "10"),
            "class" => "form-control input-sm",
        ));
    }

}
