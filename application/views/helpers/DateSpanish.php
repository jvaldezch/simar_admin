<?php

class Zend_View_Helper_DateSpanish extends Zend_View_Helper_Abstract {
    
    public function dateSpanish($value) {
        $date = strtotime($value);
        $year = date('Y', $date);
        $month = date('n', $date);
        $day = date('d', $date);
        $months = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
        return $day . '-' . $months[(int)$month - 1] . '-' . $year;
    }
    
}

