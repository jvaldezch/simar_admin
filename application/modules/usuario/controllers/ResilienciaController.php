<?php

class Usuario_ResilienciaController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appConfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout->setLayout("users/layout");
        $this->_appConfig = new Application_Model_ConfigMapper();
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV);
        $this->view->headMeta()->appendName("author", "");
        $this->view->headMeta()->appendName("description", "");
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet("/css/styles.css?" . time());
        $this->view->headScript()
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js")
                ->appendFile("/js/common/common.js?" . time());
    }

    public function preDispatch() {
        $auth = new Auth_Sessions();
        if ($auth->isAuthenticated()) {
                if ($auth->getRole() == 'user') {
                        $auth->actualizar();
                } else {
                        throw new Exception('Access restricted');
                }
        } else {
                $this->getResponse()->setRedirect('/');
        }
        $mppr = new Usuario_Model_Categories();
        $arr = $mppr->obtenerMenuCategorias();
        if (!empty($arr)) {
                $this->view->categorias = $arr;
        }
        $arr = $mppr->obtenerMenuGrupos();
        if (!empty($arr)) {
                $this->view->grupos = $arr;
        }
        $mppr = new Usuario_Model_CaProducts();
        $arr = $mppr->obtenerMenuProductos();
        if (!empty($arr)) {
                $this->view->productos = $arr;
        }
    }
    
    public function postDispatch() {

    }

    public function institucionesAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Instituciones";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/instituciones.js?" . time());
    }

    public function sectoresAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Sectores";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/sectores.js?" . time());
    }

    public function adscripcionesAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Sectores";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/adscripciones.js?" . time());
    }

    public function gradosAcademicosAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Grados académicos";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/grados-academicos.js?" . time());
    }

    public function especialistasAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Especialistas";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/especialistas.js?" . time());
    }

    public function proyectosAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Proyectos";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/proyectos.js?" . time());
    }

    public function verInstitucionAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Institución";
        $this->view->headLink()
                ->appendStylesheet("/js/common/confirm/jquery-confirm.min.css");
        $this->view->headScript()
                ->appendFile("/js/common/jquery.form.min.js")
                ->appendFile("/js/common/jquery.validate.min.js")
                ->appendFile("/js/common/confirm/jquery-confirm.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-institucion.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
                $mppr = new Usuario_Model_ResInstituciones();
                $arr = $mppr->institucion($input->id);
                $this->view->arr = $arr;
        }
    }

    public function verEspecialistaAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Investigador o especialista";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-especialista.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

    public function verAdscripcionAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Adscripción";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-adscripcion.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

    public function verSectorAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Sector";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-sector.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

    public function verGradoAcademicoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Grado académico";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-grado-academico.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

    public function verProyectoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Proyecto";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/usuario/resiliencia/ver-proyecto.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

}
