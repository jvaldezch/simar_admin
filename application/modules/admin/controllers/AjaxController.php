<?php

class Administrador_AjaxController extends Zend_Controller_Action {

    protected $_appconfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_firephp = FirePHP::getInstance(true);
        $sesiones = new App_Sesiones(new Zend_Session_Namespace("AuthSessions"), $this->_appconfig);
        if ($sesiones->actualizar()) {
            $this->view->menus = $sesiones->permisos($this->getRequest()->getModuleName(), $this->getRequest()->getControllerName(), $this->getRequest()->getActionName());
        } else {
            $this->_redirect("/default/auth/logout");
        }
    }

    public function preDispatch() {
        parent::preDispatch();
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new Zend_Controller_Request_Exception("Not an AJAX request detected");
        }
    }

    public function cargarSelloAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $post = $request->getPost();
                $directory = "c://tmp//sellos";

                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->addValidator("Count", false, array("min" => 1, "max" => 2))
                        ->addValidator("Size", false, array("min" => "1kB", "max" => "1MB"))
                        ->addValidator("Extension", false, array("extension" => "cer,key", "case" => false));
                $upload->setDestination($directory);

                $files = $upload->getFileInfo();
                foreach ($files as $fieldname => $fileinfo) {
                    if (($upload->isUploaded($fieldname)) && ($upload->isValid($fieldname))) {
                        $ext = pathinfo($fileinfo["name"], PATHINFO_EXTENSION);
                        $filename = sha1(time() . $fileinfo["name"]) . "." . $ext;

                        $upload->addFilter("Rename", $filename, $fieldname);
                        $upload->receive($fieldname);
                        if (preg_match("/cer$/i", $ext)) {
                            $keys["cer"] = $fileinfo["name"];
                            $keys["certificado"] = base64_encode(file_get_contents("c://tmp//sellos" . DIRECTORY_SEPARATOR . $filename));
                        }
                        if (preg_match("/key$/i", $ext)) {
                            $keys["key"] = $filename;
                            $keys["llave"] = base64_encode(file_get_contents("c://tmp//sellos" . DIRECTORY_SEPARATOR . $filename));
                        }
                    }
                }
                if (isset($post["password"])) {
                    $keys["password"] = $post["password"];
                }
                if (isset($post["webservice"])) {
                    $keys["webservice"] = $post["webservice"];
                }
                $privkey = openssl_get_privatekey(base64_decode($keys["llave"]), $keys["password"]);
                echo Zend_Json::encode(array("success" => true));
                return true;
            }
        } catch (Exception $ex) {
            $this->_firephp->warn($ex->getMessage());
        }
    }

    public function probarSelloAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $post = $request->getPost();
                $filters = array(
                    "*" => array("StringTrim", "StripTags"),
                    "idSello" => array("Digits"),
                );
                $validators = array(
                    "idSello" => array(
                        "Digits",
                        new Zend_Validate_Int()
                    ),
                    "edocument" => array(
                        "Alnum",
                        new Zend_Validate_Alnum(),
                        array("StringLength", 12, 15)
                    ),
                );
                $input = new Zend_Filter_Input($filters, $validators, $post);
                if ($input->isValid()) {

                    $mdl = new Administrador_Model_Sellos();
                    $sello = $mdl->obtenerSello($input->idSello);

                    $misc = new Vucem_Misc();

                    //$vucem = new Vucem_Xml(false, true);  // EDOCS
                    $vucem = new Vucem_Xml(true);         // COVES
                    $data["usuario"] = array(
                        "username" => $sello["rfc"],
                        "password" => $sello["ws"],
                        "pass" => $sello["pass"],
                        "certificado" => $sello["cer"],
                        "key" => openssl_get_privatekey(base64_decode($sello["secure"]), $sello["pass"]),
                        "new" => isset($sello["encriptacion"]) ? true : false,
                    );
                    $data["consulta"] = array(
                        "cove" => $input->edocument,
                    );

//                    $vucem->consultaEstatusOperacionEdocument($data);
//                    $xml = $vucem->getXml();
//                    $respuesta = $vucem->consumirServicioCove($xml, "DigitalizarDocumentoService");
//                    $vucem->consultaEstatusOperacionCove($data);
//                    $xml = $vucem->getXml();
//                    $respuesta = $vucem->consumirServicioCove($xml, "ConsultarRespuestaCoveService");
//                    $xml = $vucem->xmlPrueba($data);
//                    $respuesta = $vucem->consumirServicioCove($xml, "RecibirCoveService");

                    $vucem->xmlConsultaCove($data);
                    $xml = $vucem->getXml();
                    $respuesta = $vucem->consumirServicioCove($xml, "ConsultarEdocumentService");
//
//                    $this->_firephp->info(array($respuesta), "RES");
//                    $this->_firephp->info(array($xml), "XML");
//                    $this->_firephp->info($input->edocument, "DOC");

                    $array = $misc->analizarRespuesta($respuesta);
                    if (isset($array["error"])) {
                        $array["success"] = true;
                        $array["id"] = $input->idSello;
                        echo Zend_Json::encode($array);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->_firephp->info($ex->getMessage());
        }
    }

    public function editarUsuarioAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $filters = array(
                    "*" => array("StringTrim", "StripTags"),
                );
                $input = new Zend_Filter_Input($filters, null, $request->getPost());
                if ($input->isValid()) {
                    $options = array(
                        "requireAlpha" => true,
                        "requireCapital" => true,
                        "requireNumeric" => true,
                        "minPasswordLength" => 5
                    );
                    $validator = new Custom_SecurePasword($options);
                    if ($validator->isValid($input->password)) {
                        echo Zend_Json::encode(array("success" => true));
                    } else {
                        echo Zend_Json::encode(array("success" => false, "error" => $validator->getMessages()));
                    }
                    return true;
                }
            }
        } catch (Exception $ex) {
            $this->_firephp->warn($ex->getMessage());
        }
    }

    public function selloActualizarAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $filters = array(
                    "*" => array("StringTrim", "StripTags"),
                    "id" => array("Digits"),
                );
                $validators = array(
                    "id" => new Zend_Validate_Int(),
                    "ws" => array("NotEmpty"),
                );
                $input = new Zend_Filter_Input($filters, $validators, $request->getPost());
                if ($input->isValid("id") && $input->isValid("ws")) {
                    $misc = new Vucem_Misc();
                    $prev = new Vucem_Prevalidar();
                    $res = $misc->enviarCove($input->id, $input->ws);
                    if (isset($res["error"]) && $res["error"] == true) {
                        if (isset($res["messages"][0]) && preg_match("/Cannot find dispatch method for/i", $res["messages"][0])) {
                            $this->_helper->json(array("success" => false, "messages" => html_entity_decode($prev->bootstrapSuccess("La actualización de la contraseña es correcta."))));
                        }
                        $this->_helper->json(array("success" => false, "messages" => html_entity_decode($prev->bootstrapError($res["messages"]))));
                    }
                    $this->_helper->json(array("success" => true));
                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_firephp->warn($ex->getMessage());
        }
    }

    public function selloProbarAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $filters = array(
                    "*" => array("StringTrim", "StripTags"),
                    "id" => array("Digits"),
                );
                $validators = array(
                    "id" => new Zend_Validate_Int(),
                );
                $input = new Zend_Filter_Input($filters, $validators, $request->getPost());
                if ($input->isValid("id")) {
                    $misc = new Vucem_Misc();
                    $prev = new Vucem_Prevalidar();
                    $res = $misc->consultaEdoc($input->id, "COVE151AMOG25");
                    if (isset($res["error"]) && $res["error"] == true) {
                        $this->_helper->json(array("success" => false, "messages" => html_entity_decode($prev->bootstrapError($res["messages"]))));
                    }
                    $this->_helper->json(array("success" => true));
                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_firephp->warn($ex->getMessage());
        }
    }

    public function usarAgenteAction() {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $filters = array(
                    "*" => array("StringTrim", "StripTags"),
                    "idCliente" => array("Digits"),
                    "idSelloAgente" => array("Digits"),
                    "action" => array("StringToLower"),
                );
                $validators = array(
                    "idCliente" => new Zend_Validate_Int(),
                    "idSelloAgente" => new Zend_Validate_Int(),
                    "action" => new Zend_Validate_InArray(array("insert", "delete")),
                );
                $input = new Zend_Filter_Input($filters, $validators, $request->getPost());
                if ($input->isValid("idCliente") && $input->isValid("idSelloAgente") && $input->isValid("action")) {
                    $table = new Administrador_Model_Table_ClientesSelloAgente($input->getEscaped());
                    $mapper = new Administrador_Model_ClientesSelloAgente();
                    $mapper->find($table);
                    if ($input->action === "insert") {
                        if (null === ($table->getId())) {
                            $mapper->save($table);
                            $this->_helper->json(array("success" => true));
                        } else {
                            $this->_helper->json(array("success" => false, "message" => "Ya esta asginado."));
                        }
                    } elseif ($input->action === "delete") {
                        if (null !== ($table->getId())) {
                            $mapper->delete($table);
                            $this->_helper->json(array("success" => true));
                        } else {
                            $this->_helper->json(array("success" => false, "message" => "No existe."));
                        }
                    }
                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_firephp->warn($ex->getMessage());
        }
    }

}
