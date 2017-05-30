<?php

class Response {

    /**
     * request response status
     */
    private static function getStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    /**
     * Response for request
     */
    public static function sendJSON($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . self::getStatus($status));
        header('Content-type: application/json');
        echo json_encode($data);
        exit();
    }

    public static function array2XML($array, &$xml_user_info) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml_user_info->addChild("$key");
                    self::array2XML($value, $subnode);
                } else {
                    $subnode = $xml_user_info->addChild("item$key");
                    self::array2XML($value, $subnode);
                }
            } else {
                $xml_user_info->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    public static function sendXML($data, $root) {

        header('Content-type: application/xhtml+xml');
        //creating object of SimpleXMLElement
        $xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><" . $root . "></" . $root . ">");

        //function call to convert array to xml
        self::array2XML($data, $xml_user_info);

        //saving generated xml file
        $xml = $xml_user_info->asXML();

        echo $xml;
        exit();
    }

}
