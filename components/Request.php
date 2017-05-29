<?php
class Request
{

    /**
     * request response status
     */
    private function _requestStatus($code)
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
    public function response($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
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
