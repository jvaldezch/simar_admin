<?php

class Admin_GetController extends Zend_Controller_Action {

    protected $_appConfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_appConfig = new Application_Model_ConfigMapper();
    }

    public function preDispatch() {
        parent::preDispatch();
        /*if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new Zend_Controller_Request_Exception("Not an AJAX request detected");
        }*/
        $auth = new Auth_Sessions();
        if ($auth->isAuthenticated()) {
                $auth->actualizar();
        } else {
            throw new Zend_Controller_Request_Exception("Session is required!");
        }
    }

    public function productosAction() {
        try {
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "page" => array("Digits"),
                "size" => array("Digits"),
                "year" => array("Digits"),
                "type" => array("StringToLower"),
            );
            $v = array(
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
                "year" => array(new Zend_Validate_Int()),
                "type" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());

            $mppr = new Admin_Model_SatmoNc();
            $arr = $mppr->obtener($input->year, $input->type);

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
            $paginator->setItemCountPerPage($input->size);
            $paginator->setCurrentPageNumber($input->page);
            $view->paginator = $paginator;

            $view->dataDir = $this->_appConfig->getParam("opendap_dir");
            $view->satmoDir = $this->_appConfig->getParam("satmo_https");

            $paginatorControl = $view->paginationControl($paginator);

            $this->_helper->json(array("success" => true, "results" => $view->render("productos.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function categoriasAction() {
        try {
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "page" => array("Digits"),
                "size" => array("Digits"),
            );
            $v = array(
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());

            $mppr = new Admin_Model_Categories();
            $arr = $mppr->obtener();

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
            $paginator->setItemCountPerPage($input->size);
            $paginator->setCurrentPageNumber($input->page);
            $view->paginator = $paginator;

            $paginatorControl = $view->paginationControl($paginator);

            $this->_helper->json(array("success" => true, "results" => $view->render("categorias.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function poligonalesAction() {
        try {
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "page" => array("Digits"),
                "size" => array("Digits"),
            );
            $v = array(
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());

            $mppr = new Admin_Model_AnpAlerts();
            $arr = $mppr->obtener();

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
            $paginator->setItemCountPerPage($input->size);
            $paginator->setCurrentPageNumber($input->page);
            $view->paginator = $paginator;

            $paginatorControl = $view->paginationControl($paginator);

            $this->_helper->json(array("success" => true, "results" => $view->render("poligonales.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function buscarProductoAction() {
        try {
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "page" => array("Digits"),
                "size" => array("Digits"),
            );
            $v = array(
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
                "search" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());

            $mppr = new Admin_Model_SatmoNc();
            $arr = $mppr->buscar($input->search);

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
            $paginator->setItemCountPerPage($input->size);
            $paginator->setCurrentPageNumber($input->page);
            $view->paginator = $paginator;

            $view->dataDir = $this->_appConfig->getParam("opendap_dir");
            $view->satmoDir = $this->_appConfig->getParam("satmo_url");

            $paginatorControl = $view->paginationControl($paginator);

            $this->_helper->json(array("success" => true, "results" => $view->render("productos.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerProductoAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
            );
            $v = array(
                "rid" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("rid")) {

                $dataDir = $this->_appConfig->getParam("opendap_dir");
                $satmoDir = $this->_appConfig->getParam("satmo_https"); 

                $mppr = new Admin_Model_SatmoNcRs();
                $row = $mppr->obtener($input->rid);
                $arr = array();
                if (!empty($row)) {
                    foreach($row as $v) {
                        if ($v["format"] == 'GTiff') {

                            $png = str_replace('.tif', '.png', $v["path"]);
                            $kmz = str_replace('.tif', '.kmz', $v["path"]);

                            $arr["download"] = str_replace($dataDir, $satmoDir, $v["path"]);
                            $arr["folder"] = str_replace($dataDir, $satmoDir, dirname($v["path"]));
                            $arr["filename"] = $v["filename"];
                            if (file_exists($kmz)) {
                                $arr["kmz"] = str_replace($dataDir, $satmoDir, $kmz);
                            }
                            if (file_exists($png)) {
                                $arr["png"] = str_replace($dataDir, $satmoDir, $png);
                            }
                            $arr["year"] = $v["year"];
                            $arr["day"] = $v["day"];
                            $arr["composition"] = $v["composition"];
                            $arr["week"] = $v["week"];
                            $arr["month"] = $v["month"];
                            $arr["product"] = $v["product"];
                            $arr["sensor"] = $v["sensor"];
                            $arr["min"] = $v["min"];
                            $arr["max"] = $v["max"];
                            $arr["mean"] = $v["mean"];
                            $arr["projection"] = $v["projection"];
                            $arr["bit_depth"] = $v["bit_depth"];
                            $arr["pix_res"] = $v["pix_res"];
                            $arr["std_dev"] = $v["std_dev"];
                            $arr["no_data"] = $v["no_data"];
                            $arr["x_min"] = $v["x_min"];
                            $arr["y_min"] = $v["y_min"];
                            $arr["x_max"] = $v["x_max"];
                            $arr["y_max"] = $v["y_max"];
                        }
                        if ($v["format"] == 'mapserver') {
                            $arr["url"] = $v["path"];
                        }
                    }
                }
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerAniosAction() {
        try {
            $mppr = new Admin_Model_SatmoNc();
            $arr = $mppr->obtenerAnios();
            if (!empty($arr)) {
                $this->_helper->json(array("success" => true, "results" => $arr));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerMetadataAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
            );
            $v = array(
                "composition" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("composition")) {
                $mppr = new Admin_Model_CaProducts();
                $arr = $mppr->obtener($input->composition);
                if (!empty($arr)) {
                    $this->_helper->json(array("success" => true, "html" => $arr["description"]));
                } else {
                    $this->_helper->json(array("success" => false));
                }
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function productosDeCategoriaAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
                "page" => array("Digits"),
                "size" => array("Digits"),
            );
            $v = array(
                "id" => array("NotEmpty" ,new Zend_Validate_Int()),
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("id")) {

                $view = new Zend_View();
                $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
                $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

                $mppr = new Admin_Model_CaProducts();
                $arr = $mppr->productosDeCaterogia($input->id);

                $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
                $paginator->setItemCountPerPage($input->size);
                $paginator->setCurrentPageNumber($input->page);
                $view->paginator = $paginator;

                $paginatorControl = $view->paginationControl($paginator);

                $this->_helper->json(array("success" => true, "results" => $view->render("productos-de-categoria.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function datosPoligonalAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
                "page" => array("Digits"),
                "size" => array("Digits"),
            );
            $v = array(
                "id" => array("NotEmpty" ,new Zend_Validate_Int()),
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("id")) {

                $view = new Zend_View();
                $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
                $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

                $mppr = new Admin_Model_AnpAlertsLevel();
                $arr = $mppr->datosPoligonal($input->id);

                $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
                $paginator->setItemCountPerPage($input->size);
                $paginator->setCurrentPageNumber($input->page);
                $view->paginator = $paginator;

                $paginatorControl = $view->paginationControl($paginator);

                $this->_helper->json(array("success" => true, "results" => $view->render("datos-poligonal.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function bitacoraAction() {
        try {
            $this->_appConfig = new Application_Model_ConfigMapper();
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "size" => array("Digits"),
            );
            $v = array(
                "size" => array(new Zend_Validate_Int(), "default" => 5),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if (APPLICATION_ENV == "production") {
                $directory = $this->_appConfig->getParam("log_files");
            } else {
                $directory = "D:\\Tmp\\log_simar";
            }
            $files = array();
            $dir = new DirectoryIterator($directory);
            $i = 0;
            foreach ($dir as $fileinfo) {
                if ($fileinfo->getFilename() != '.' && $fileinfo->getFilename() != '..') {
                    $files[$fileinfo->getMTime()] = array(
                        "filename" => $fileinfo->getFilename(),
                        "fecha" => $fileinfo->getMTime(),
                    );
                }
            }
            krsort($files);
            $view->files = $files;
            $this->_helper->json(array("success" => true, "results" => $view->render("bitacora.phtml")));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function archivoBitacoraAction() {
        try {
            $this->_appConfig = new Application_Model_ConfigMapper();
            $f = array(
                "*" => array("StringTrim", "StripTags"),
            );
            $v = array(
                "filename" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("filename")) {
                if (APPLICATION_ENV == "production") {
                    $directory = $this->_appConfig->getParam("log_files");
                } else {
                    $directory = "D:\\Tmp\\log_simar";
                }
                if (file_exists($directory . DIRECTORY_SEPARATOR . $input->filename)) {
                    $content = file_get_contents($directory . DIRECTORY_SEPARATOR . $input->filename);
                } else{
                    $content = '';
                }
                $this->_helper->json(array("success" => true, "results" => $content));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerProductoDeCategoriaAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
            );
            $v = array(
                "id" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("id")) {

                $dataDir = $this->_appConfig->getParam("opendap_dir");
                $satmoDir = $this->_appConfig->getParam("satmo_url"); 

                $mppr = new Admin_Model_CaProducts();
                $row = $mppr->productoDeCaterogia($input->id);
                $arr = array();
                if (!empty($row)) {
                    $arr = $row;
                }
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function calendarAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {

                $view = new Zend_View();
                $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
                $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

                $view->month = $input->month;
                $view->year = $input->year;

                $this->_helper->json(array("success" => true, "results" => $view->render("calendar.phtml")));

                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function commandAction() {

        echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><body>';
        echo '<style>body {font-family:"Ubuntu";background: #fff}</style>';
        ob_implicit_flush(true);
        ob_end_flush();

        $cmd = $this->_appConfig->getParam("pysimar_home") . "/./conversion.py --sensor ghrsst --composition m-nsst --type kmz --year 2018 --month 6";
        print $cmd . '<br>';

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

        if (is_resource($process)) {

            while ($s = fgets($pipes[1])) {
                print $s . '<br>';
            }
        }
        echo '</body></html>';
    }

    public function obtenerNsstAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerNsst($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerWnsstAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerWnsst($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerWynsstAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerWynsst($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerMnsstAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerMnsst($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerWhsAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerWhs($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerDhwAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerDhw($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerSbaAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "month" => array("Digits"),
            );
            $v = array(
                "year" => array(new Zend_Validate_Int()),
                "month" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("month")) {
                $mppr = new Admin_Model_SatmoNc();
                $arr = $mppr->obtenerSba($input->year, $input->month);
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

}
