<?php

class Default_IndexController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appConfig = null;

    public function init() {
        $this->_appConfig = new Application_Model_ConfigMapper();
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $this->view->headMeta()->appendName('author', '');
        $this->view->headMeta()->appendName('description', '');
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet('/webfontkit/stylesheet.css')
                ->appendStylesheet('/css/styles.css');
        $this->view->headScript()
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js");
    }
    
    public function preDispatch() {
        $this->view->title = $this->_appConfig->getParam('title') . " | Login";
    }
    
    public function postDispatch() {
        $route = trim(DIRECTORY_SEPARATOR . $this->_request->getModuleName() . DIRECTORY_SEPARATOR . $this->_request->getControllerName() . DIRECTORY_SEPARATOR . $this->_request->getActionName() . '.js');
        if (file_exists(realpath(APPLICATION_PATH . '/../public/js/') . $route)) {
            $this->view->headScript()->appendFile('/js' . $route . "?" . time());
        }
    }

    public function indexAction() {
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet("/webfontkit/stylesheet.css")
                ->appendStylesheet("/tooltipster/css/tooltipster.css")
                ->appendStylesheet("/tooltipster/css/themes/tooltipster-light.css")
                ->appendStylesheet("/css/styles.css");
        $this->view->headScript()
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/common/jquery.form.min.js")
                ->appendFile("/js/common/jquery.validate.min.js")
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js")
                ->appendFile("/tooltipster/js/jquery.tooltipster.min.js");
        try {
            $form = new Application_Form_Login();
            $username = $this->getRequest()->getCookie('myVucemUsr');
            if (isset($username)) {
                $form->populate(array(
                    "username" => $username
                ));
            }
            $this->view->welcome = $this->_appConfig->getParam('welcome');
            $this->view->form = $form;   
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function aboutAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $m = new Usuarios_Model_PedimentosPartidasMapper();
        $t = new Usuarios_Model_Table_PedimentosPartidas(array(
            "idPedimento" => 5,
            "partida" => 9,
        ));
        $m->find($t);
        if(null !== ($t->getId())) {
            $filename = "/home/vucem/5_part9.xml";
            file_put_contents($filename, base64_decode($t->getXml()));
        }
    }

    public function removeSessionsAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $model = new Application_Model_Sesiones();
        $model->removeExpired();
    }

}
