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
                ->appendStylesheet('/css/styles.css');
        $this->view->headScript()
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js");
    }
    
    public function preDispatch() {
        $this->view->title = $this->_appConfig->getParam('title') . " | Login";
    }
    
    public function postDispatch() {

    }

    public function indexAction() {
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet("/js/common/tooltipster/css/tooltipster.bundle.min.css");
        $this->view->headScript()
            ->appendFile("/js/common/jquery.form.min.js")
            ->appendFile("/js/common/jquery.validate.min.js")
            ->appendFile("/js/common/tooltipster/js/tooltipster.bundle.min.js")
            ->appendFile("/js/common/common.js")
            ->appendFile("/js/default/index/index.js");
        try {
            $form = new Application_Form_Login();
            $username = $this->getRequest()->getCookie('SimarPanelv1User');
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

}
