<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initSetupBaseUrl() {
        $this->bootstrap('frontcontroller');
        $controller = Zend_Controller_Front::getInstance();
        $controller->setControllerDirectory(array(
            'default' => APPLICATION_PATH . '/modules/default/controllers',
            'admin' => APPLICATION_PATH . '/modules/admin/controllers',
        ));
    }
    
    public function _initPagination() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(array('pagination.phtml', 'default'));
    }

    protected function _initDefaultModule() {
        $this->bootstrap('FrontController');
        require_once APPLICATION_PATH . '/modules/default/Bootstrap.php';
        $defaultBootstrap = new Default_Bootstrap($this);
        $defaultBootstrap->bootstrap();
        return $defaultBootstrap;
    }

    protected function _initAutoload() {
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => '',
            'resourceTypes' => array(
                'model' => array(
                    'path' => 'models/',
                    'namespace' => 'Model_'
                )
            ),
        ));
        return $autoLoader;
    }

    protected function _initDatabase() {
        $this->bootstrap('multidb');
        $multidb = $this->getPluginResource('multidb');
        $snib = $multidb->getDb('snib');
        $snib->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Registry::set('snib', $snib);
    }

    protected function _initSessions() {
    }

}
