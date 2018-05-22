<?php

class Administrador_PostController extends Zend_Controller_Action {

    protected $_appconfig = null;
    protected $_session;
    protected $_postData;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $sesiones = new App_Sesiones(new Zend_Session_Namespace("AuthSessions"), $this->_appconfig);
        if ($sesiones->actualizar()) {
            $this->view->menus = $sesiones->permisos($this->getRequest()->getModuleName(), $this->getRequest()->getControllerName(), $this->getRequest()->getActionName());
        } else {
            $this->_redirect("/default/auth/logout");
        }
    }

    public function preDispatch() {
        parent::preDispatch();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_postData = $request->getPost();
        } else {
            throw new Zend_Controller_Request_Exception("Not post requested.");
        }
    }

    public function asignarAduanaAction() {
        $form = $form = new Administrador_Form_AduanasAgente();
        if ($form->isValid($this->_postData)) {
            $input = $form->getValues();
            $mdl = new Administrador_Model_AduanasAgente();
            if (!($mdl->verificar($input["idAgente"], $input["idAduana"]))) {
                $insert = $mdl->agregar($input["idAgente"], $input["idAduana"]);
                if ($insert === true) {
                    $this->_redirect("/administrador/agentes/aduanas?id=" . $input["idAgente"]);
                }
            }
        } else {
            $this->_redirect("/administrador/agentes/aduanas?id=" . $input->idAgente);
        }
    }

}
