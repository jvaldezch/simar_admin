<?php

class Default_ErrorController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout('error');
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $this->view->headMeta()->appendName('author', '');
        $this->view->headMeta()->appendName('description', '');
        $this->view->headLink()
                ->appendStylesheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css")
                ->appendStylesheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css")
                ->appendStylesheet('/css/error.css?' . time());
        $this->view->headScript()
                ->appendFile("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js")
                ->appendFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js");
    }

    public function errorAction() {
        
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->error = 404;
                $this->view->message = 'Página no encontrada';
                break;
            
            // check for any other exception
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
            if ($errors->exception instanceof My_Exception_Blocked) {
                $this->getResponse()->setHttpResponseCode(403);
                $this->view->error = 403;
                $this->view->message = $errors->exception->getMessage();
                break;
            }
            // fall through if not of type My_Exception_Blocked
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->error = 500;
                $this->view->message = 'Error en la aplicación';
                break;
        }

        // Log exception, if logger available
        if (($log = $this->getLog())) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

    public function forbiddenAction() {
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'Se ha denegado el acceso.';
            return;
        }
        $this->view->request = $errors->request;
    }

}
