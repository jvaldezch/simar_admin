<?php

class Admin_PostController extends Zend_Controller_Action {

    protected $_appconfig = null;
    protected $_session;
    protected $_postData;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function preDispatch() {
        $auth = new Auth_Sessions();
        if ($auth->isAuthenticated()) {
                $auth->actualizar();
        } else {
            throw new Zend_Controller_Request_Exception("Session is required!");
        }
    }

    public function guardarProductoDeCategoriaAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                    "id" => "Digits",
                );
                $v = array(
                    "id" => array("NotEmpty", new Zend_Validate_Int()),
                    "content" => array("NotEmpty"),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("id") && $input->isValid("content")) {

                    $mppr = new Admin_Model_CaProducts();

                    $arr = array('description' => html_entity_decode($input->content), 'updated_at' => date('Y-m-d H:i:s'));
                    if ($mppr->actualizarProductoDeCaterogia($input->id, $arr)) {
                        $this->_helper->json(array("success" => true));
                    }
                    $this->_helper->json(array("success" => false));

                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function guardarCategoriaAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                    "id" => "Digits",
                );
                $v = array(
                    "id" => array("NotEmpty", new Zend_Validate_Int()),
                    "content" => array("NotEmpty"),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("id") && $input->isValid("content")) {

                    $mppr = new Admin_Model_Categories();

                    $arr = array('description' => html_entity_decode($input->content), 'updated_at' => date('Y-m-d H:i:s'));
                    if ($mppr->actualizarCaterogia($input->id, $arr)) {
                        $this->_helper->json(array("success" => true));
                    }
                    $this->_helper->json(array("success" => false));

                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function guardarDetalleCategoriaAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                    "id" => "Digits",
                    "order" => "Digits",
                );
                $v = array(
                    "id" => array("NotEmpty", new Zend_Validate_Int()),
                    "name" => array("NotEmpty"),
                    "abbreviation" => array("NotEmpty"),
                    "main_name" => array("NotEmpty"),
                    "english_name" => array("NotEmpty"),
                    "order" => array("NotEmpty", new Zend_Validate_Int()),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("id")) {

                    $mppr = new Admin_Model_Categories();
                    $arr = array(
                        'name' => html_entity_decode($input->name), 
                        'abbreviation' => html_entity_decode($input->abbreviation), 
                        'main_name' => html_entity_decode($input->main_name), 
                        'english_name' => html_entity_decode($input->english_name), 
                        'order' => $input->order, 
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($mppr->actualizarCaterogia($input->id, $arr)) {
                        $this->_helper->json(array("success" => true));
                    }
                    $this->_helper->json(array("success" => false));

                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function guardarDetalleGrupoAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                    "id" => "Digits",
                    "order" => "Digits",
                );
                $v = array(
                    "id" => array("NotEmpty", new Zend_Validate_Int()),
                    "name" => array("NotEmpty"),
                    "abbreviation" => array("NotEmpty"),
                    "main_name" => array("NotEmpty"),
                    "english_name" => array("NotEmpty"),
                    "order" => array("NotEmpty", new Zend_Validate_Int()),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("id")) {

                    $mppr = new Admin_Model_Categories();
                    $arr = array(
                        'name' => html_entity_decode($input->name), 
                        'abbreviation' => html_entity_decode($input->abbreviation), 
                        'main_name' => html_entity_decode($input->main_name), 
                        'english_name' => html_entity_decode($input->english_name), 
                        'order' => $input->order, 
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($mppr->actualizarCaterogia($input->id, $arr)) {
                        $this->_helper->json(array("success" => true));
                    }
                    $this->_helper->json(array("success" => false));

                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function guardarParametrosProductoDeCategoriaAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                    "id" => "Digits",
                );
                $v = array(
                    "id" => array("NotEmpty", new Zend_Validate_Int()),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("id")) {
                    $this->_helper->json(array("success" => true));
                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

}
