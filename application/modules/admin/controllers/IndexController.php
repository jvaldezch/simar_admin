<?php

class Admin_IndexController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appConfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout->setLayout("admin/layout");
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
                if ($auth->getRole() == 'admin') {
                        $this->view->profile = $auth->getProfile();
                        $this->view->username = $auth->getUsername();
                        $auth->actualizar();
                } else {
                        throw new Exception('Access restricted');
                }
        } else {
                $this->getResponse()->setRedirect('/');
        }
        $mppr = new Admin_Model_Categories();
        $arr = $mppr->obtenerMenuCategorias();
        if (!empty($arr)) {
                $this->view->categorias = $arr;
        }
        $arr = $mppr->obtenerMenuGrupos();
        if (!empty($arr)) {
                $this->view->grupos = $arr;
        }
        $mppr = new Admin_Model_CaProducts();
        $arr = $mppr->obtenerMenuProductos();
        if (!empty($arr)) {
                $this->view->productos = $arr;
        }
    }
    
    public function postDispatch() {

    }

    public function indexAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/admin/index/index.js?" . time());
    }

    public function satmoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | SATMO";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css")
                ->appendStylesheet("/js/common/contentxmenu/jquery.contextMenu.min.css");
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/locales/bootstrap-datepicker.es.min.js")
                ->appendFile("/js/common/contentxmenu/jquery.contextMenu.min.js")
                ->appendFile("/js/admin/index/satmo.js?" . time());
    }

    public function satcoralAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | SATcoral";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css")
                ->appendStylesheet("/js/common/contentxmenu/jquery.contextMenu.min.css");
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/locales/bootstrap-datepicker.es.min.js")
                ->appendFile("/js/common/contentxmenu/jquery.contextMenu.min.js")
                ->appendFile("/js/admin/index/satcoral.js?" . time());
    }

    public function verProductoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Producto";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/admin/index/ver-producto.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
        );
        $v = array(
                "rid" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("rid")) {
                $mppr = new Admin_Model_SatmoNcRs();
                $arr = $mppr->obtenerProducto($input->rid);
                if (isset($arr)) {
                        $composition = $arr["composition"] = 'day' ? 'nsst' : $arr["compostion"];
                        $url = "https://simar.conabio.gob.mx:8443/tiles/satmo/" . $arr["sensor"] . "/" . $composition . "/" . date("Y-m-d", strtotime($arr["product_date"])) . "/wmts/nsst/webmercator/{z}/{x}/{y}.png";
                        $this->view->url = $url;
                        $this->view->layerName = strtoupper($arr["sensor"]) . " " . date("Y-m-d", strtotime($arr["product_date"]));
                        $this->view->xMin = $arr["x_min"];
                        $this->view->yMin = $arr["y_min"];
                        $this->view->xMax = $arr["x_max"];
                        $this->view->yMax = $arr["y_max"];
                        $this->view->filename = $arr["filename"];
                }
        }
    }

    public function categoriasAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Categorías";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/categorias.js?" . time());
    }

    public function gruposAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Grupos";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/grupos.js?" . time());
    }

    public function productosAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Productos";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/productos.js?" . time());
    }

    public function verCategoriaAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Categoría";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css")
                ->appendStylesheet("/js/common/froala/css/froala_editor.css")
                ->appendStylesheet("/js/common/froala/css/froala_style.css")
                ->appendStylesheet("/js/common/froala/css/plugins/code_view.css")
                ->appendStylesheet("/js/common/froala/css/plugins/draggable.css")
                ->appendStylesheet("/js/common/froala/css/plugins/colors.css")
                ->appendStylesheet("/js/common/froala/css/plugins/emoticons.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image_manager.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image.css")
                ->appendStylesheet("/js/common/froala/css/plugins/line_breaker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/table.css")
                ->appendStylesheet("/js/common/froala/css/plugins/char_counter.css")
                ->appendStylesheet("/js/common/froala/css/plugins/video.css")
                ->appendStylesheet("/js/common/froala/css/plugins/fullscreen.css")
                ->appendStylesheet("/js/common/froala/css/plugins/file.css")
                ->appendStylesheet("/js/common/froala/css/plugins/quick_insert.css")
                ->appendStylesheet("/js/common/froala/css/plugins/help.css")
                ->appendStylesheet("/js/common/froala/css/third_party/spell_checker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/special_characters.css")
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css")
                ->appendStylesheet("/js/common/confirm/jquery-confirm.min.css");
        $this->view->headScript()
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js")
                ->appendFile("/js/common/froala/js/froala_editor.min.js")
                ->appendFile("/js/common/froala/js/plugins/align.min.js")
                ->appendFile("/js/common/froala/js/plugins/char_counter.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_beautifier.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_view.min.js")
                ->appendFile("/js/common/froala/js/plugins/colors.min.js")
                ->appendFile("/js/common/froala/js/plugins/draggable.min.js")
                ->appendFile("/js/common/froala/js/plugins/emoticons.min.js")
                ->appendFile("/js/common/froala/js/plugins/entities.min.js")
                ->appendFile("/js/common/froala/js/plugins/file.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_size.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_family.min.js")
                ->appendFile("/js/common/froala/js/plugins/fullscreen.min.js")
                ->appendFile("/js/common/froala/js/plugins/image.min.js")
                ->appendFile("/js/common/froala/js/plugins/image_manager.min.js")
                ->appendFile("/js/common/froala/js/plugins/line_breaker.min.js")
                ->appendFile("/js/common/froala/js/plugins/inline_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/link.min.js")
                ->appendFile("/js/common/froala/js/plugins/lists.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_format.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/quick_insert.min.js")
                ->appendFile("/js/common/froala/js/plugins/quote.min.js")
                ->appendFile("/js/common/froala/js/plugins/table.min.js")
                ->appendFile("/js/common/froala/js/plugins/save.min.js")
                ->appendFile("/js/common/froala/js/plugins/url.min.js")
                ->appendFile("/js/common/froala/js/plugins/video.min.js")
                ->appendFile("/js/common/froala/js/plugins/help.min.js")
                ->appendFile("/js/common/froala/js/plugins/print.min.js")
                ->appendFile("/js/common/froala/js/third_party/spell_checker.min.js")
                ->appendFile("/js/common/froala/js/plugins/special_characters.min.js")
                ->appendFile("/js/common/froala/js/plugins/word_paste.min.js")
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/common/jquery.form.min.js")
                ->appendFile("/js/common/jquery.validate.min.js")
                ->appendFile("/js/common/confirm/jquery-confirm.min.js")
                ->appendFile("/js/admin/index/ver-categoria.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
                $mppr = new Admin_Model_Categories();
                $arr = $mppr->obtenerCategoria($input->id);
                if (isset($arr)) {
                        $this->view->id = $input->id;
                        $this->view->name = $arr["name"];
                        $this->view->abbreviation = $arr["abbreviation"];
                        $this->view->english_name = $arr["english_name"];
                        $this->view->main_name = $arr["main_name"];
                        $this->view->order = $arr["order"];
                        $this->view->description = $arr["description"];
                }
        }
    }

    public function verGrupoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Ver grupo";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css")
                ->appendStylesheet("/js/common/froala/css/froala_editor.css")
                ->appendStylesheet("/js/common/froala/css/froala_style.css")
                ->appendStylesheet("/js/common/froala/css/plugins/code_view.css")
                ->appendStylesheet("/js/common/froala/css/plugins/draggable.css")
                ->appendStylesheet("/js/common/froala/css/plugins/colors.css")
                ->appendStylesheet("/js/common/froala/css/plugins/emoticons.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image_manager.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image.css")
                ->appendStylesheet("/js/common/froala/css/plugins/line_breaker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/table.css")
                ->appendStylesheet("/js/common/froala/css/plugins/char_counter.css")
                ->appendStylesheet("/js/common/froala/css/plugins/video.css")
                ->appendStylesheet("/js/common/froala/css/plugins/fullscreen.css")
                ->appendStylesheet("/js/common/froala/css/plugins/file.css")
                ->appendStylesheet("/js/common/froala/css/plugins/quick_insert.css")
                ->appendStylesheet("/js/common/froala/css/plugins/help.css")
                ->appendStylesheet("/js/common/froala/css/third_party/spell_checker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/special_characters.css")
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css")
                ->appendStylesheet("/js/common/confirm/jquery-confirm.min.css");
        $this->view->headScript()
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js")
                ->appendFile("/js/common/froala/js/froala_editor.min.js")
                ->appendFile("/js/common/froala/js/plugins/align.min.js")
                ->appendFile("/js/common/froala/js/plugins/char_counter.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_beautifier.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_view.min.js")
                ->appendFile("/js/common/froala/js/plugins/colors.min.js")
                ->appendFile("/js/common/froala/js/plugins/draggable.min.js")
                ->appendFile("/js/common/froala/js/plugins/emoticons.min.js")
                ->appendFile("/js/common/froala/js/plugins/entities.min.js")
                ->appendFile("/js/common/froala/js/plugins/file.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_size.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_family.min.js")
                ->appendFile("/js/common/froala/js/plugins/fullscreen.min.js")
                ->appendFile("/js/common/froala/js/plugins/image.min.js")
                ->appendFile("/js/common/froala/js/plugins/image_manager.min.js")
                ->appendFile("/js/common/froala/js/plugins/line_breaker.min.js")
                ->appendFile("/js/common/froala/js/plugins/inline_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/link.min.js")
                ->appendFile("/js/common/froala/js/plugins/lists.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_format.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/quick_insert.min.js")
                ->appendFile("/js/common/froala/js/plugins/quote.min.js")
                ->appendFile("/js/common/froala/js/plugins/table.min.js")
                ->appendFile("/js/common/froala/js/plugins/save.min.js")
                ->appendFile("/js/common/froala/js/plugins/url.min.js")
                ->appendFile("/js/common/froala/js/plugins/video.min.js")
                ->appendFile("/js/common/froala/js/plugins/help.min.js")
                ->appendFile("/js/common/froala/js/plugins/print.min.js")
                ->appendFile("/js/common/froala/js/third_party/spell_checker.min.js")
                ->appendFile("/js/common/froala/js/plugins/special_characters.min.js")
                ->appendFile("/js/common/froala/js/plugins/word_paste.min.js")
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/common/jquery.form.min.js")
                ->appendFile("/js/common/jquery.validate.min.js")
                ->appendFile("/js/common/confirm/jquery-confirm.min.js")
                ->appendFile("/js/admin/index/ver-grupo.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
                $mppr = new Admin_Model_Categories();
                $arr = $mppr->obtenerCategoria($input->id);
                if (isset($arr)) {
                        $this->view->id = $input->id;
                        $this->view->name = $arr["name"];
                        $this->view->abbreviation = $arr["abbreviation"];
                        $this->view->english_name = $arr["english_name"];
                        $this->view->main_name = $arr["main_name"];
                        $this->view->order = $arr["order"];
                        $this->view->description = $arr["description"];
                }
        }
    }

    public function poligonalesAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | ANP regionales";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/poligonales.js?" . time());
    }

    public function bitacoraAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | ANP regionales";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/bitacora.js?" . time());
    }

    public function calendarioAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Calendario";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/calendario.js?" . time());   
    }

    public function produccionAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Producción";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css");        
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/locales/bootstrap-datepicker.es.min.js")
                ->appendFile("/js/admin/index/produccion.js?" . time());   
    }

    public function verMapaAction() {
        $this->_helper->layout()->disableLayout();
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
        );
        $v = array(
                "rid" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("rid")) {
                $mppr = new Admin_Model_SatmoNcRs();
                $arr = $mppr->obtenerProducto($input->rid);
                if (isset($arr)) {
                        $composition = $arr["composition"] = 'day' ? 'nsst' : $arr["compostion"];
                        $url = "http://35.196.161.155:8085/tiles/satmo/" . $arr["sensor"] . "/" . $composition . "/" . date("Y-m-d", strtotime($arr["product_date"])) . "/wmts/nsst/webmercator/{z}/{x}/{y}.png";
                        $this->view->url = $url;
                        $this->view->layerName = strtoupper($arr["sensor"]) . " " . date("Y-m-d", strtotime($arr["product_date"]));
                        $this->view->xMin = $arr["x_min"];
                        $this->view->yMin = $arr["y_min"];
                        $this->view->xMax = $arr["x_max"];
                        $this->view->yMax = $arr["y_max"];
                        $this->view->filename = $arr["filename"];
                }
        }
    }

    public function verPoligonalAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Ver categoría";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/index/ver-poligonal.js?" . time());
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

    public function verProductoDeCategoriaAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Ver producto de categoría";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css")
                ->appendStylesheet("/js/common/froala/css/froala_editor.css")
                ->appendStylesheet("/js/common/froala/css/froala_style.css")
                ->appendStylesheet("/js/common/froala/css/plugins/code_view.css")
                ->appendStylesheet("/js/common/froala/css/plugins/draggable.css")
                ->appendStylesheet("/js/common/froala/css/plugins/colors.css")
                ->appendStylesheet("/js/common/froala/css/plugins/emoticons.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image_manager.css")
                ->appendStylesheet("/js/common/froala/css/plugins/image.css")
                ->appendStylesheet("/js/common/froala/css/plugins/line_breaker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/table.css")
                ->appendStylesheet("/js/common/froala/css/plugins/char_counter.css")
                ->appendStylesheet("/js/common/froala/css/plugins/video.css")
                ->appendStylesheet("/js/common/froala/css/plugins/fullscreen.css")
                ->appendStylesheet("/js/common/froala/css/plugins/file.css")
                ->appendStylesheet("/js/common/froala/css/plugins/quick_insert.css")
                ->appendStylesheet("/js/common/froala/css/plugins/help.css")
                ->appendStylesheet("/js/common/froala/css/third_party/spell_checker.css")
                ->appendStylesheet("/js/common/froala/css/plugins/special_characters.css")
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css")
                ->appendStylesheet("/js/common/confirm/jquery-confirm.min.css");
        $this->view->headScript()
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js")
                ->appendFile("/js/common/froala/js/froala_editor.min.js")
                ->appendFile("/js/common/froala/js/plugins/align.min.js")
                ->appendFile("/js/common/froala/js/plugins/char_counter.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_beautifier.min.js")
                ->appendFile("/js/common/froala/js/plugins/code_view.min.js")
                ->appendFile("/js/common/froala/js/plugins/colors.min.js")
                ->appendFile("/js/common/froala/js/plugins/draggable.min.js")
                ->appendFile("/js/common/froala/js/plugins/emoticons.min.js")
                ->appendFile("/js/common/froala/js/plugins/entities.min.js")
                ->appendFile("/js/common/froala/js/plugins/file.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_size.min.js")
                ->appendFile("/js/common/froala/js/plugins/font_family.min.js")
                ->appendFile("/js/common/froala/js/plugins/fullscreen.min.js")
                ->appendFile("/js/common/froala/js/plugins/image.min.js")
                ->appendFile("/js/common/froala/js/plugins/image_manager.min.js")
                ->appendFile("/js/common/froala/js/plugins/line_breaker.min.js")
                ->appendFile("/js/common/froala/js/plugins/inline_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/link.min.js")
                ->appendFile("/js/common/froala/js/plugins/lists.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_format.min.js")
                ->appendFile("/js/common/froala/js/plugins/paragraph_style.min.js")
                ->appendFile("/js/common/froala/js/plugins/quick_insert.min.js")
                ->appendFile("/js/common/froala/js/plugins/quote.min.js")
                ->appendFile("/js/common/froala/js/plugins/table.min.js")
                ->appendFile("/js/common/froala/js/plugins/save.min.js")
                ->appendFile("/js/common/froala/js/plugins/url.min.js")
                ->appendFile("/js/common/froala/js/plugins/video.min.js")
                ->appendFile("/js/common/froala/js/plugins/help.min.js")
                ->appendFile("/js/common/froala/js/plugins/print.min.js")
                ->appendFile("/js/common/froala/js/third_party/spell_checker.min.js")
                ->appendFile("/js/common/froala/js/plugins/special_characters.min.js")
                ->appendFile("/js/common/froala/js/plugins/word_paste.min.js")
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/common/jquery.form.min.js")
                ->appendFile("/js/common/jquery.validate.min.js")
                ->appendFile("/js/common/confirm/jquery-confirm.min.js")
                ->appendFile("/js/admin/index/ver-producto-de-categoria.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
                $this->view->id = $input->id;
        }
    }

}
