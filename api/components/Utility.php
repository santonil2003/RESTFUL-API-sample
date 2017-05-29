<?php

class Utility {

    /**
     * advance print r
     * @param type $data
     * @param type $label
     */
    public static function r($data, $label = '') {
        $trace = debug_backtrace();
        $html = '';
        $html .= '<p style=background:red;padding:4px;margin:0px;>';
        $html .= ' Trace : ' . $trace[0]['file'] . ', Line :';
        $html .= '<b>' . $trace[0]['line'] . '</b>';
        $html .= '</p>';
        echo $html;
        if ($label && pathinfo($label, PATHINFO_EXTENSION) != 'txt') {
            echo $label . '<hr>';
        }
        echo '<pre style="background:#e0e0e0;padding:4px;margin:0px;clear:both;">';
        print_r($data);
        echo '</pre>';
    }
}
