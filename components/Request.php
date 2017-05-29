<?php
class Request
{

    /**
     * request response status
     */
    private static function requestStatus($code)
    {
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
    public static function jsonResponse($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . self::requestStatus($status));
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public static function array2XML($array, &$xml_user_info)
    {
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

    public static function xmlResponse($data, $root)
    {
        //creating object of SimpleXMLElement
        $xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><" . $root . "></" . $root . ">");

        //function call to convert array to xml
        self::array2XML($data, $xml_user_info);

        //saving generated xml file
        $xml = $xml_user_info->asXML();

        header("HTTP/1.1 " . $status . " " . self::requestStatus($status));
        header('Content-type: application/rss+xm');

        echo $xml;

    }

    /**
     * isset check with default value
     * @param type $dataArray
     * @param type $key
     * @param type $default
     */
    public static function getValue($dataArray, $key, $default = '')
    {

        if (isset($dataArray[$key])) {
            return $dataArray[$key];
        }

        return $default;
    }

}
