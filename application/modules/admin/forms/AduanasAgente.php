<?php

class Administrador_Form_AduanasAgente extends Zend_Form {

    public function init() {
        $this->clearDecorators();
        $this->addDecorator("FormElements")
                ->addDecorator("Form");
        $this->setAction("/administrador/post/asignar-aduana");

        $this->setElementDecorators(array(
            array("ViewHelper"),
            array("Errors"),
            array("Description"),
            array("Label", array("class" => "control-label")),
            array("HtmlTag", array("tag" => "div", "class" => "form-group")),
        ));

        $this->addElement("hidden", "idAgente", array(
            "filters" => array("StripTags"),
            "required" => true,
            "validators" => array(
                array("Digits", new Zend_Validate_Int()),
            ),
        ));

        $tbl = new Application_Model_DbTable_Aduanas();
        $rows = $tbl->fetchAll();
        $array = array("" => "---");
        foreach ($rows as $item) {
            $array[$item["id"]] = $item["aduana"] . (isset($item["seccion"]) ? $item["seccion"] : "0") . " - " . $item["nombre"];
        }

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

        $this->addElement("select", "idAduana", array(
            "label" => "ADUANA:",
            "attribs" => array("autocomplete" => "off", "tabindex" => "1"),
            "class" => "form-control input-sm required",
            "multioptions" => $array,
            "filters" => array("Digits", "StripTags"),
            "required" => true,
            "validators" => array(
                array("Digits", new Zend_Validate_Int()),
            ),
        ));
    }

}
