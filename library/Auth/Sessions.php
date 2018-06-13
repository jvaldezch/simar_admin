<?php

class Auth_Sessions {

    protected $username;
    protected $password;
    protected $session;
    protected $sessionExp = 3600;

    function setPassword($password) {
        $this->password = $password;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    public function __set($name, $value) {
        $method = "set" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid property: " . $name);
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid property: " . $name);
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = "set" . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->session = new Zend_Session_Namespace('SimarPanelv1');
    }

    public function isAuthenticated() {
        if (isset($this->session->authenticated) && $this->session->authenticated == true) {
            return true;
        }
        return;
    }

    protected function _iniciarSesion() {
        Zend_Session::regenerateId();
        $this->session = new Zend_Session_Namespace('SimarPanelv1');
        if ($this->session->isLocked()) {
            $this->session->unLock();
            $this->session->setExpirationSeconds($this->sessionExp);
        }
        $this->session->authenticated = true;
        $this->session->username = $this->username;
        $this->session->lock();
    }

    protected function _hash($value) {
        return base64_encode(sha1($value));
    }

    public function autorizar() {
        if ($this->username == 'admin') {
            if ($this->password == 'admin') {

                $this->_iniciarSesion();

                $token = $this->_hash(Zend_Session::getId());

                setcookie('SimarPanelv1User', $this->username, time() + (3600 * 24 * 5), '/');
                setcookie('SimarPanelv1Session', $token, time() + (3600 * 24 * 5), '/');

                return array("success" => true, "landing" => "/admin");

            } else {
                return array("success" => false, "password" => "Contraseña no válida");
            }
        } else {
            return array("success" => false, "username" => "Usuario no existe");
        }
    }

    public function actualizar() {
        $this->session->unLock();
        $this->session->setExpirationSeconds($this->sessionExp);
        $this->session->lock();
    }

    public function cerrarSesion() {
        setcookie("SimarPanelv1Session", "", null, "/");
        $this->session->unsetAll();
        return true;
    }
    
}
