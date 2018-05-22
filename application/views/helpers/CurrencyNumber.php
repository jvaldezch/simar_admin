<?php

class Zend_View_Helper_CurrencyNumber extends Zend_View_Helper_Abstract {

    public function currencyNumber($value, $pretty = null, $decimals = 2) {
        if (isset($pretty)) {
            return '<div class="currency"><span>$</span><div class="number">' . number_format($value, $decimals, '.', ',') . '</div></div>';
        } else {
            return ' ' . number_format($value, $decimals, '.', ',') . ' ';
        }
    }

}
