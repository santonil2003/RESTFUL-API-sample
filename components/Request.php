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
