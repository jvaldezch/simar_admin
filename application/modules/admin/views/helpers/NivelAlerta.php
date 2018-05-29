<?php

class Zend_View_Helper_NivelAlerta extends Zend_View_Helper_Abstract {

    public function nivelAlerta($level) {
        switch($level) {
            case 1:
                return '<img src="/images/01_nohayestres.png" />';
            case 2:
                return '<img src="/images/02_vigilancia.png" />';
            case 3:
                return '<img src="/images/03_posibleblanqueamiento.png" />';
            case 4:
                return '<img src="/images/04_probableblanqueamiento.png" />';
            case 5:
                return '<img src="/images/05_probablemortalidad.png" />';

        }
    }

}
